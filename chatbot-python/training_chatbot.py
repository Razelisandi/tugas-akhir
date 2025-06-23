import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.linear_model import LogisticRegression
import joblib

df = pd.read_csv("chatbot_dataset.csv")

X = df['pattern']
y = df['intent']


vectorizer = TfidfVectorizer()
X_vectorized = vectorizer.fit_transform(X)


model = LogisticRegression()
model.fit(X_vectorized, y)


joblib.dump((vectorizer, model), "chatbot_model.joblib")
