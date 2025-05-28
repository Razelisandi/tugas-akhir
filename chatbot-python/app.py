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

education_model = joblib.load("education_model.pkl")
education_features = joblib.load("education_features.pkl")

@app.route("/predict_edu", methods=["POST"])
def predict_edu():
    minat = request.form.get("minat")
    nilai = int(request.form.get("nilai"))
    tingkat = request.form.get("tingkat")

    # Buat DataFrame input satu baris
    input_data = pd.DataFrame([{
        "minat_" + minat: 1,
        "tingkat_" + tingkat: 1,
        "nilai": nilai
    }])

    # Pastikan semua fitur ada
    for col in education_features:
        if col not in input_data.columns:
            input_data[col] = 0

    # Urutkan kolom agar sesuai dengan model
    input_data = input_data[education_features]

    # Prediksi jurusan
    prediction = education_model.predict(input_data)[0]

    return jsonify({"jurusan_rekomendasi": prediction})
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
