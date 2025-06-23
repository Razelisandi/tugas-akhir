from flask import Flask, request, jsonify, render_template
from flask_cors import CORS
import pandas as pd
from sentence_transformers import SentenceTransformer, util
import joblib

app = Flask(__name__)
CORS(app)

# ========== NLP MODEL UNTUK REKOMENDASI KARIER ==========
embedder = SentenceTransformer('all-MiniLM-L6-v2')

# Muat daftar karier (bisa dari file CSV juga)
df_karier = pd.read_csv("career_dataset.csv")
list_karier = df_karier["Career"].unique().tolist()

# Precompute embedding untuk semua karier
karier_embeddings = embedder.encode(list_karier, convert_to_tensor=True)

# ========== MODEL UNTUK REKOMENDASI PENDIDIKAN ==========
education_model = joblib.load("model_pendidikan.pkl")
label_encoders = joblib.load("label_encoders.pkl")

# ---------- Rekomendasi Pendidikan ----------
@app.route("/predict_edu", methods=["POST"])
def predict_edu():
    field_of_study = request.form.get("field_of_study")
    education_level = request.form.get("education_level")
    skills = request.form.get("skills")
    career_goals = request.form.get("career_goals")
    location_preference = request.form.get("location_preference")
    learning_style = request.form.get("learning_style")

    input_dict = {
        'field_of_study': field_of_study,
        'education_level': education_level,
        'skills': skills,
        'career_goals': career_goals,
        'location_preference': location_preference,
        'learning_style': learning_style,
    }

    encoded_input = {}
    for key, value in input_dict.items():
        if key in label_encoders:
            encoder = label_encoders[key]
            try:
                encoded_input[key] = encoder.transform([value])[0]
            except ValueError:
                return jsonify({"error": f"Input '{value}' tidak dikenali pada fitur '{key}'."})
        else:
            encoded_input[key] = value

    input_df = pd.DataFrame([encoded_input])
    prediction = education_model.predict(input_df)[0]
    target_encoder = label_encoders["recommended_program"]
    predicted_program = target_encoder.inverse_transform([prediction])[0]

    return jsonify({"jurusan_rekomendasi": predicted_program})

@app.route("/form_edu")
def form_edu():
    return render_template("form_edu.html")

# ---------- Rekomendasi Karier (NLP Semantic) ----------
@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()
    minat = data.get("minat", "")
    kemampuan = data.get("kemampuan", "")

    # Gabungkan input user jadi satu kalimat
    input_text = minat + " " + kemampuan

    # Buat embedding dari input user
    input_embedding = embedder.encode(input_text, convert_to_tensor=True)

    # Hitung kemiripan dengan semua karier
    cosine_scores = util.cos_sim(input_embedding, karier_embeddings)

    # Ambil karier dengan nilai kemiripan tertinggi
    top_index = cosine_scores.argmax().item()
    rekomendasi = list_karier[top_index]

    return jsonify({"rekomendasi": rekomendasi})

if __name__ == '__main__':
    app.run(port=5001)
