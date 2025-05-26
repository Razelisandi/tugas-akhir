from flask import Flask, request, jsonify
import joblib
import numpy as np
from flask_cors import CORS
from scipy.sparse import hstack

app = Flask(__name__)
CORS(app)

# Load model dan NLP tools
model = joblib.load("career_model.pkl")
tfidf_minat = joblib.load("tfidf_minat.pkl")
tfidf_kemampuan = joblib.load("tfidf_kemampuan.pkl")
le_karier = joblib.load("le_karier.pkl")

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
