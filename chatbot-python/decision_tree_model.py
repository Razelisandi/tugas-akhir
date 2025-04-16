import pandas as pd
from sklearn.tree import DecisionTreeClassifier
import joblib
from sklearn.preprocessing import LabelEncoder

# Dataset sederhana
data = {
    "minat": ["teknologi", "desain", "bisnis", "rebahan", "musik", "olahraga", "seni", "pendidikan", "kesehatan", "lingkungan"],
    "kemampuan": ["logika", "kreatif", "komunikasi", "tidur", "musik", "kerja sama", "berpikir analitis", "pengajaran", "penulisan", "manajemen proyek"],
    "karier": ["programmer", "designer", "marketing", "doctor", "musician", "athlete", "artist", "teacher", "doctor", "environmentalist"]
}

df = pd.DataFrame(data)

# Encode teks ke angka
le_minat = LabelEncoder()
le_kemampuan = LabelEncoder()
le_karier = LabelEncoder()

df["minat_enc"] = le_minat.fit_transform(df["minat"])
df["kemampuan_enc"] = le_kemampuan.fit_transform(df["kemampuan"])
df["karier_enc"] = le_karier.fit_transform(df["karier"])

# Training model
X = df[["minat_enc", "kemampuan_enc"]]
y = df["karier_enc"]

model = DecisionTreeClassifier()
model.fit(X, y)

# Simpan model dan encoder
joblib.dump(model, "career_model.pkl")
joblib.dump(le_minat, "le_minat.pkl")
joblib.dump(le_kemampuan, "le_kemampuan.pkl")
joblib.dump(le_karier, "le_karier.pkl")
