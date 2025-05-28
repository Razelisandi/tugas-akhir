import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.linear_model import LogisticRegression
import joblib

# Load dataset
df = pd.read_csv("chatbot_dataset.csv")

# Fitur dan label
X = df['pattern']
y = df['intent']

# Vektorisasi teks
vectorizer = TfidfVectorizer()
X_vectorized = vectorizer.fit_transform(X)

# Model klasifikasi
model = LogisticRegression()
model.fit(X_vectorized, y)

# Simpan model dan vectorizer
joblib.dump((vectorizer, model), "chatbot_model.joblib")
