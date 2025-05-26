import pandas as pd
from sklearn.tree import DecisionTreeClassifier
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.preprocessing import LabelEncoder
from sklearn.model_selection import train_test_split
import joblib
import numpy as np
from scipy.sparse import hstack

# Dataset
data = {
    "IT Developer": [
        ("menulis", "Technical Writer"),
        ("menggambar", "UI/UX Designer"),
        ("public speaking", "IT Consultant"),
        ("logika", "Backend Developer"),
        ("analisis", "Data Analyst"),
        ("komunikasi", "Project Manager IT"),
        ("ngoding", "Fullstack Developer"),
        ("troubleshooting", "IT Support Specialist"),
        ("keamanan siber", "Cybersecurity Analyst"),
        ("matematika", "Software Engineer"),
    ],
    "Desain": [
        ("menggambar", "Illustrator"),
        ("warna & komposisi", "Graphic Designer"),
        ("fotografi", "Digital Imaging Specialist"),
        ("ui/ux", "Web Designer"),
        ("motion", "Motion Graphic Artist"),
        ("kreativitas", "Art Director"),
        ("branding", "Creative Strategist"),
        ("storytelling", "Visual Content Creator"),
        ("observasi", "Layout Designer"),
        ("software design", "Multimedia Designer"),
    ],
    "Kesehatan": [
        ("peduli", "Perawat"),
        ("biologi", "Dokter Umum"),
        ("konsentrasi tinggi", "Ahli Bedah"),
        ("teliti", "Apoteker"),
        ("empati", "Psikolog Klinis"),
        ("public speaking", "Penyuluh Kesehatan"),
        ("fisik kuat", "Paramedis"),
        ("menghafal", "Dokter Spesialis"),
        ("analisis", "Peneliti Medis"),
        ("komunikasi", "Konselor Gizi"),
    ],
    "Pendidikan": [
        ("public speaking", "Guru"),
        ("sabar", "Dosen"),
        ("menulis", "Penulis Buku Pendidikan"),
        ("observasi", "Psikolog Pendidikan"),
        ("mengajar", "Tutor Online"),
        ("kreativitas", "Pengembang Media Edukasi"),
        ("analisis", "Peneliti Pendidikan"),
        ("literasi digital", "Instruktur E-learning"),
        ("komunikasi", "Konselor Sekolah"),
        ("interpersonal", "Pelatih Karier"),
    ],
    "Bisnis & Manajemen": [
        ("negosiasi", "Sales Manager"),
        ("analisis", "Business Analyst"),
        ("komunikasi", "Public Relations"),
        ("kepemimpinan", "Manajer Proyek"),
        ("strategi", "Konsultan Bisnis"),
        ("pemasaran digital", "Digital Marketer"),
        ("akuntansi", "Auditor"),
        ("problem solving", "Entrepreneur"),
        ("time management", "Event Organizer"),
        ("pengambilan keputusan", "Operation Manager"),
    ],
    "Musik": [
        ("bermain gitar", "Gitaris"),
        ("menyanyi", "Vokalis"),
        ("komposisi musik", "Komposer"),
        ("teori musik", "Guru Musik"),
        ("produksi musik", "Produser Musik"),
    ],
    "Olahraga": [
        ("ketangkasan fisik", "Pelatih Olahraga"),
        ("strategi tim", "Manajer Tim Olahraga"),
        ("motivasi", "Konsultan Kebugaran"),
        ("pengajaran", "Instruktur Senam"),
        ("pengamatan", "Wasit"),
    ],
    "Seni": [
        ("melukis", "Pelukis"),
        ("patung", "Pemahat"),
        ("kreativitas", "Seniman Kontemporer"),
        ("galeri seni", "Kurator Seni"),
        ("fotografi", "Fotografer Seni"),
    ],
    "Lingkungan": [
        ("analisis", "Ahli Lingkungan"),
        ("penelitian", "Peneliti Lingkungan"),
        ("komunikasi", "Aktivis Lingkungan"),
        ("perencanaan", "Konsultan Lingkungan"),
        ("lapangan", "Petugas Konservasi"),
    ],
}


rows = []
for minat, km_list in data.items():
    for kemampuan, karier in km_list:
        rows.append({"minat": minat, "kemampuan": kemampuan, "karier": karier})

df = pd.DataFrame(rows)
print(df.head())

# Vectorizer untuk teks
tfidf_minat = TfidfVectorizer()
tfidf_kemampuan = TfidfVectorizer()

X_minat = tfidf_minat.fit_transform(df["minat"])
X_kemampuan = tfidf_kemampuan.fit_transform(df["kemampuan"])

# Gabungkan dua fitur
X = hstack([X_minat, X_kemampuan])

# Encode label karier
le_karier = LabelEncoder()
y = le_karier.fit_transform(df["karier"])

# Train model
model = DecisionTreeClassifier()
model.fit(X, y)

# Simpan model dan vectorizer
joblib.dump(model, "career_model.pkl")
joblib.dump(tfidf_minat, "tfidf_minat.pkl")
joblib.dump(tfidf_kemampuan, "tfidf_kemampuan.pkl")
joblib.dump(le_karier, "le_karier.pkl")
