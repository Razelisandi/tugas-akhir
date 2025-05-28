import pandas as pd
from sklearn.tree import DecisionTreeClassifier
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.preprocessing import LabelEncoder
from sklearn.model_selection import train_test_split
import joblib
from scipy.sparse import hstack

# Load dataset
df = pd.read_csv('career_dataset.csv')  # kolom: Field, Skill, Career

# Rename kolom agar konsisten
df = df.rename(columns={"Field": "minat", "Skill": "kemampuan", "Career": "karier"})

# Vectorizer untuk teks minat dan kemampuan
tfidf_minat = TfidfVectorizer()
tfidf_kemampuan = TfidfVectorizer()

X_minat = tfidf_minat.fit_transform(df["minat"])
X_kemampuan = tfidf_kemampuan.fit_transform(df["kemampuan"])

# Gabungkan fitur minat + kemampuan
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
