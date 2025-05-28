from flask import Flask, request, jsonify
import requests
from flask_cors import CORS
from openai import OpenAI
import joblib

app = Flask(__name__)
CORS(app)  # Agar bisa diakses dari frontend Laravel

# Kumpulan jawaban untuk topik tertentu
# responses = {
#     "halo": "Halo juga! Ada yang bisa aku bantu seputar karier atau pendidikan?",
#     "apa itu karier": "Karier adalah perjalanan profesional seseorang dalam dunia kerja.",
#     "jurusan": "Jurusan adalah bidang studi yang kamu pilih di perguruan tinggi, seperti Teknik Informatika, Psikologi, atau Akuntansi.",
#     "bingung jurusan": "Kamu bisa mulai dari minat dan bakatmu, atau tujuan karier ke depannya.",
#     "rekomendasi jurusan": "Kalau kamu suka logika, coba Teknik. Kalau suka interaksi sosial, coba Psikologi atau Komunikasi.",
#     "sma ipa": "Dari jurusan IPA, kamu bisa masuk Teknik, Kedokteran, MIPA, bahkan beberapa jurusan sosial juga.",
#     "sma ips": "Jurusan IPS bisa lanjut ke Ekonomi, Hukum, Manajemen, Komunikasi, dan lainnya.",
#     "universitas terbaik": "Beberapa universitas terbaik di Indonesia adalah UI, ITB, UGM, dan UNS juga bagus lho!",
#     "karier introvert": "Beberapa karier yang cocok untuk introvert antara lain: Penulis, Desainer Grafis, Programmer, Data Analyst.",
#     "karier extrovert": "Coba bidang seperti Marketing, Public Relations, Pengajar, atau Host Event."
# }

# Sinonim atau frasa lain dari pertanyaan yang mirip
# keywords = {
#     "halo": ["halo", "hai", "hello", "hey"],
#     "apa itu karier": ["apa itu karier", "pengertian karier", "karier itu apa"],
#     "jurusan": ["jurusan", "prodi", "program studi", "pilihan jurusan"],
#     "bingung jurusan": ["bingung milih jurusan", "susah pilih jurusan", "nggak tau mau ambil jurusan apa"],
#     "rekomendasi jurusan": ["rekomendasi jurusan", "jurusan yang cocok", "aku cocok jurusan apa"],
#     "sma ipa": ["saya anak ipa", "jurusan ipa", "sma ipa bisa masuk jurusan apa"],
#     "sma ips": ["saya anak ips", "jurusan ips", "sma ips bisa masuk jurusan apa"],
#     "universitas terbaik": ["kampus terbaik", "universitas top", "kampus favorit"],
#     "karier introvert": ["kerja buat introvert", "cocok untuk pemalu", "introvert cocok kerja apa"],
#     "karier extrovert": ["kerja buat extrovert", "extrovert cocok kerja apa"]
# }

# Contoh endpoint untuk mengambil data beasiswa dari API eksternal
@app.route("/beasiswa", methods=["GET"])
def get_beasiswa():
    try:
        # Misalnya kita ambil data dari API beasiswa (ganti URL dengan API yang valid)
        response = requests.get("https://api.example.com/beasiswa")  # Ganti dengan API yang relevan
        if response.status_code == 200:
            data = response.json()  # Mengambil data JSON dari API
            return jsonify({"beasiswa": data})
        else:
            return jsonify({"error": "Gagal mengambil data beasiswa"}), 500
    except Exception as e:
        return jsonify({"error": str(e)}), 500

client = OpenAI(
    base_url="https://openrouter.ai/api/v1",
    api_key="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"
)

vectorizer, model = joblib.load("chatbot_model.joblib")

@app.route("/chat", methods=["POST"])
def chat():
    data = request.get_json()
    user_message = data.get("message", "")

    if user_message in ["halo", "hi", "hai", "halo bot", "hello"]:
        return jsonify({"response": "Halo! Aku adalah asisten edukasi. Aku bisa bantu kamu memilih jurusan kuliah dan karier terbaik. Mau mulai dari mana?"})

    try:
        completion = client.chat.completions.create(
            model="google/gemini-2.5-flash-preview-05-20",
            messages=[
                # {
                #     "role": "system",
                #     "content": (
                #     "Kamu adalah chatbot edukasi untuk siswa SMA/SMK yang ingin tahu jurusan kuliah dan karier. Jawablah dengan gaya santai, ramah, dan seperti ngobrol bareng teman. Jangan terlalu formal. Jangan langsung memberi daftar panjang. Tanyakan dulu minat dan pelajaran favorit mereka. Jangan pernah mengakhiri percakapan sepihak—biarkan user yang memutuskan kapan ingin berhenti."
                #     )
                # },
                {
                    "role": "user",
                    "content": user_message
                }
            ],
            max_tokens=256,
            extra_headers={
                "HTTP-Referer": "#",
                "X-Title": "Sistem Konselor AI Razel"
            }
        )

        return jsonify({"response": completion.choices[0].message.content})

    except Exception as e:
        return jsonify({"response": f"Terjadi kesalahan: {str(e)}"})

    # Jika user meminta informasi beasiswa, kita arahkan ke endpoint beasiswa
    # if "beasiswa" in user_message:
    #     return jsonify({"response": "Kamu ingin informasi beasiswa, tunggu sebentar..."})

    # response = "Maaf, aku belum mengerti. Bisa diulang pertanyaannya?"

    # Logika untuk mengenali kata kunci dan memberikan respons yang sesuai
    # for key, variants in keywords.items():
    #     for variant in variants:
    #         if variant in user_message:
    #             response = responses.get(key, response)
    #             break
    #     if response != "Maaf, aku belum mengerti. Bisa diulang pertanyaannya?":
    #         break

    # Jika respons dari chatbot adalah tentang beasiswa, kita panggil API beasiswa
    # if "beasiswa" in response:
    #     try:
    #         beasiswa_res = requests.get("http://127.0.0.1:5000/beasiswa")
    #         if beasiswa_res.status_code == 200:
    #             beasiswa_data = beasiswa_res.json()
    #             response = f"Ini informasi beasiswa terbaru: {beasiswa_data.get('beasiswa', 'Tidak ada informasi beasiswa terbaru.')}"
    #         else:
    #             response = "Gagal mengambil informasi beasiswa."
    #     except Exception as e:
    #         response = f"Gagal mengambil informasi beasiswa: {str(e)}"



    # return jsonify({"response": response})

if __name__ == "__main__":
    app.run(debug=False)
