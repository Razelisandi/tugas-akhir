import pandas as pd
from sklearn.tree import DecisionTreeClassifier
from sklearn.preprocessing import LabelEncoder
import joblib
from flask import Flask, request, jsonify
from flask_cors import CORS

# === Training Model ===
# Load dataset from CSV
df = pd.read_csv('education_dataset.csv')

# Encode kolom teks ke angka
label_encoders = {}
for column in df.columns:
    if df[column].dtype == 'object':
        le = LabelEncoder()
        df[column] = le.fit_transform(df[column])
        label_encoders[column] = le

X = df.drop('recommended_program', axis=1)
y = df['recommended_program']

model = DecisionTreeClassifier()
model.fit(X, y)

# Simpan model dan encoders untuk dipakai di API
joblib.dump(model, 'model_pendidikan.pkl')
joblib.dump(label_encoders, 'label_encoders.pkl')

print("Model dan encoders berhasil disimpan.")

# Load universities dataset
universities_df = pd.read_csv('universities_dataset.csv')

# === API Flask ===
app = Flask(__name__)
CORS(app)

@app.route('/education-predict', methods=['POST'])
def predict_education():
    try:
        data = request.json
        input_data = {
            'field_of_study': data.get('field_of_study', ''),
            'education_level': data.get('education_level', ''),
            'skills': data.get('skills', ''),
            'career_goals': data.get('career_goals', ''),
            'location_preference': data.get('location_preference', ''),
            'learning_style': data.get('learning_style', '')
        }

        # Load model dan encoder
        model = joblib.load('model_pendidikan.pkl')
        label_encoders = joblib.load('label_encoders.pkl')

        input_df = pd.DataFrame([input_data])

        # Encode setiap kolom
        for col in input_df.columns:
            le = label_encoders.get(col)
            if le:
                try:
                    input_df[col] = le.transform(input_df[col])
                except ValueError:
                    return jsonify({'recommendation': 'Input value not recognized: ' + col}), 400

        # Prediksi
        prediction = model.predict(input_df)[0]
        recommended_program = label_encoders['recommended_program'].inverse_transform([prediction])[0]

        # Mapping recommended_program to university majors for better matching
        major_mapping = {
            'computer science': 'it',
            'data science': 'it',
            'business management': 'business',
            'visual communication': 'design',
            'nursing': 'kedokteran',
            'education': 'education',
            'kedokteran': 'kedokteran'
        }
        mapped_major = major_mapping.get(recommended_program.lower(), recommended_program.lower())

        # Debug prints
        print(f"Recommended program: {recommended_program}")
        print(f"Mapped major: {mapped_major}")

        # Jika rekomendasi ada di daftar jurusan kampus, berikan daftar kampus teratas
        filtered_universities = universities_df[universities_df['major'].str.lower() == mapped_major]
        print(f"Filtered universities count: {len(filtered_universities)}")
        if not filtered_universities.empty:
            # Urutkan berdasarkan ranking
            sorted_universities = filtered_universities.sort_values('ranking')
            # Ambil 5 teratas
            top_universities = sorted_universities.head(5)
            # Buat list kampus
            university_list = top_universities[['university_name', 'ranking']].to_dict(orient='records')
            return jsonify({'recommendation': recommended_program, 'top_universities': university_list})

        return jsonify({'recommendation': recommended_program})

    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5003)
