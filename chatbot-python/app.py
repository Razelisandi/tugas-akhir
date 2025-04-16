from flask import Flask, request, jsonify
import joblib
import numpy as np
from flask_cors import CORS

app = Flask(__name__)

# Mengizinkan CORS
CORS(app)

# Memuat model dan encoder
model = joblib.load("career_model.pkl")
le_minat = joblib.load("le_minat.pkl")
le_kemampuan = joblib.load("le_kemampuan.pkl")
le_karier = joblib.load("le_karier.pkl")

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()  # Mengambil data yang dikirimkan oleh frontend
    minat = data['minat']
    kemampuan = data['kemampuan']

    # Encoding input
    minat_enc = le_minat.transform([minat])[0]
    kemampuan_enc = le_kemampuan.transform([kemampuan])[0]

    # Melakukan prediksi
    input_data = np.array([[minat_enc, kemampuan_enc]])
    pred = model.predict(input_data)
    karier = le_karier.inverse_transform(pred)[0]

    return jsonify({'rekomendasi': karier})

if __name__ == '__main__':
    app.run(port=5001)
