import requests
import pandas as pd
import random

# ==== BAGIAN 1: GENERATE EDUCATION DATASET ====
response = requests.get("https://universities.hipolabs.com/search?country=Indonesia")
universities = response.json()

fields = ["IT", "Business", "Design", "Education", "Health"]
skills_map = {
    "IT": ["Coding", "Networking", "Cybersecurity"],
    "Business": ["Marketing", "Finance", "Leadership"],
    "Design": ["Creative Thinking", "UI/UX", "Animation"],
    "Education": ["Teaching", "Public Speaking", "Curriculum Design"],
    "Health": ["Caregiving", "Nutrition", "Public Health"]
}
career_map = {
    "IT": ["Software Engineer", "Data Analyst", "IT Support"],
    "Business": ["Manager", "Entrepreneur", "Accountant"],
    "Design": ["Graphic Designer", "UI/UX Designer", "Animator"],
    "Education": ["Teacher", "Trainer", "Lecturer"],
    "Health": ["Nurse", "Health Educator", "Therapist"]
}
education_levels = ["High School", "Diploma", "Bachelor", "Master"]
learning_styles = ["online", "offline", "hybrid"]
locations = ["Urban", "Rural"]

rows = []
for _ in range(200):
    field = random.choice(fields)
    skill = random.choice(skills_map[field])
    career = random.choice(career_map[field])
    level = random.choice(education_levels)
    location = random.choice(locations)
    style = random.choice(learning_styles)
    uni = random.choice(universities)["name"]

    rows.append({
        "field_of_study": field,
        "education_level": level,
        "skills": skill,
        "career_goals": career,
        "location_preference": location,
        "learning_style": style,
        "recommended_program": uni
    })

df_edu = pd.DataFrame(rows)
df_edu.to_csv("education_dataset.csv", index=False)
print("✅ education_dataset.csv berhasil dibuat!")

# ==== BAGIAN 2: GENERATE UNIVERSITIES DATASET ====
majors = ["it", "business", "design", "education", "kedokteran"]
data = []

for i, uni in enumerate(universities[:100]):
    name = uni["name"]
    domain = uni["domains"][0] if uni["domains"] else "example.edu"
    major = random.choice(majors)
    ranking = random.randint(1, 300)

    data.append({
        "university_name": name,
        "domain": domain,
        "major": major,
        "ranking": ranking
    })

df_univ = pd.DataFrame(data)
df_univ.to_csv("universities_dataset.csv", index=False)
print("✅ universities_dataset.csv berhasil dibuat!")
