from flask import Flask, request, jsonify
import fitz  # PyMuPDF
import re
import os

app = Flask(__name__)
UPLOAD_FOLDER = 'uploads'
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

# Fungsi untuk ekstrak teks dari PDF
def extract_text_from_pdf(file_path):
    text = ''
    try:
        with fitz.open(file_path) as doc:
            for page in doc:
                text += page.get_text()
    except Exception as e:
        print(f"Terjadi kesalahan saat membaca PDF: {e}")
    return text

# Fungsi sederhana ekstraksi data dari teks
def extract_information(text):
    result = {}

    # 1. Nama (asumsi: baris paling atas dengan huruf besar)
    lines = text.splitlines()
    for line in lines:
        if line.strip() and line.strip().istitle():
            result["nama_lengkap"] = line.strip()
            break

    # 2. Email
    email_match = re.search(r'[\w\.-]+@[\w\.-]+', text)
    result["email"] = email_match.group(0) if email_match else None

    # 3. Riwayat Sekolah/Kampus
    sekolah_match = re.findall(r'(Universitas|Institut|Sekolah|SMK|SMA|STM)[^\n]{0,100}', text, re.IGNORECASE)
    result["riwayat_sekolah"] = sekolah_match[0].strip() if sekolah_match else None

    # 4. Jurusan
    jurusan_match = re.findall(r'Jurusan\s?:?\s?(.*)', text, re.IGNORECASE)
    result["riwayat_jurusan"] = jurusan_match[0].strip() if jurusan_match else None

    # 5. Riwayat Pekerjaan
    pekerjaan_match = re.findall(r'(?:Pengalaman Kerja|Pekerjaan|Experience)[\s\S]{0,500}', text, re.IGNORECASE)
    result["riwayat_pekerjaan"] = pekerjaan_match[0].strip() if pekerjaan_match else None

    # 6. Magang / Kegiatan
    magang_match = re.findall(r'(?:Magang|Internship|Organisasi|Kegiatan)[\s\S]{0,300}', text, re.IGNORECASE)
    result["riwayat_kegiatan"] = magang_match[0].strip() if magang_match else None

    # 7. Prestasi
    prestasi_match = re.findall(r'(?:Prestasi|Achievements?)[\s\S]{0,300}', text, re.IGNORECASE)
    result["riwayat_prestasi"] = prestasi_match[0].strip() if prestasi_match else None

    return result

@app.route('/upload-cv', methods=['POST'])
def upload_cv():
    if 'cv' not in request.files:
        return jsonify({'error': 'No file part'}), 400

    file = request.files['cv']
    if file.filename == '':
        return jsonify({'error': 'No selected file'}), 400

    if file and file.filename.endswith('.pdf'):
        file_path = os.path.join(UPLOAD_FOLDER, file.filename)
        file.save(file_path)

        text = extract_text_from_pdf(file_path)
        data = extract_information(text)

        return jsonify({'data': data})

    return jsonify({'error': 'Invalid file format. Only PDF allowed.'}), 400

if __name__ == '__main__':
    app.run(port=5002, debug=True)
