import pandas as pd
from sklearn.tree import DecisionTreeClassifier
import joblib


data_pendidikan = [
    ("teknologi", 90, "S1", "Teknik Informatika"),
    ("teknologi", 75, "D3", "Manajemen Informatika"),
    ("biologi", 85, "S1", "Biologi Murni"),
    ("kesehatan", 88, "S1", "Kedokteran"),
    ("kesehatan", 70, "D3", "Keperawatan"),
    ("bisnis", 80, "S1", "Manajemen"),
    ("bisnis", 65, "D3", "Administrasi Bisnis"),
    ("seni", 90, "S1", "Desain Komunikasi Visual"),
    ("seni", 72, "D3", "Multimedia"),
    ("pendidikan", 85, "S1", "Pendidikan Bahasa Inggris"),
    ("pendidikan", 75, "D3", "Pendidikan Anak Usia Dini"),
    ("matematika", 92, "S1", "Matematika"),
    ("fisika", 88, "S1", "Fisika"),
    ("kimia", 87, "S1", "Kimia"),
    ("lingkungan", 80, "S1", "Teknik Lingkungan"),
]


df = pd.DataFrame(data_pendidikan, columns=["minat", "nilai", "tingkat", "jurusan"])


df_encoded = pd.get_dummies(df[["minat", "tingkat"]])
X = pd.concat([df_encoded, df["nilai"]], axis=1)
y = df["jurusan"]

# Buat model Decision Tree
model = DecisionTreeClassifier()
model.fit(X, y)

# Simpan model
joblib.dump(model, "education_model.pkl")
joblib.dump(df_encoded.columns.tolist(), "education_features.pkl")

print("Model rekomendasi pendidikan berhasil dilatih dan disimpan.")
