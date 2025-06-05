from flask import Flask, request, jsonify, render_template
import joblib
import numpy as np
from flask_cors import CORS
from scipy.sparse import hstack
import pandas as pd

app = Flask(__name__)
CORS(app)

# Load model dan NLP tools
model = joblib.load("career_model.pkl")
tfidf_minat = joblib.load("tfidf_minat.pkl")
tfidf_kemampuan = joblib.load("tfidf_kemampuan.pkl")
le_karier = joblib.load("le_karier.pkl")

education_model = joblib.load("model_pendidikan.pkl")
label_encoders = joblib.load("label_encoders.pkl")

@app.route("/predict_edu", methods=["POST"])
def predict_edu():
    # Ambil data dari form atau frontend
    field_of_study = request.form.get("field_of_study")
    education_level = request.form.get("education_level")
    skills = request.form.get("skills")
    career_goals = request.form.get("career_goals")
    location_preference = request.form.get("location_preference")
    learning_style = request.form.get("learning_style")

    # Buat dictionary input
    input_dict = {
        'field_of_study': field_of_study,
        'education_level': education_level,
        'skills': skills,
        'career_goals': career_goals,
        'location_preference': location_preference,
        'learning_style': learning_style,
    }

    # Encode input dengan LabelEncoder
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

    # Ubah ke DataFrame
    input_df = pd.DataFrame([encoded_input])

    # Prediksi jurusan
    prediction = education_model.predict(input_df)[0]

    # Decode hasil prediksi
    target_encoder = label_encoders["recommended_program"]
    predicted_program = target_encoder.inverse_transform([prediction])[0]

    return jsonify({"jurusan_rekomendasi": predicted_program})

@app.route("/form_edu")
def form_edu():
    return render_template("form_edu.html")



@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()
    minat = data['minat']
    kemampuan = data['kemampuan']

    # Transformasi teks input dengan TF-IDF
    minat_vec = tfidf_minat.transform([minat])
    kemampuan_vec = tfidf_kemampuan.transform([kemampuan])

    # Gabungkan vektor
    input_vec = hstack([minat_vec, kemampuan_vec])

    # Prediksi
    pred = model.predict(input_vec)
    karier = le_karier.inverse_transform(pred)[0]

    return jsonify({'rekomendasi': karier})

if __name__ == '__main__':
    app.run(port=5001)
