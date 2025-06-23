<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use App\Models\CvData;

class CVController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'cv_pdf' => 'required|file|mimes:pdf|max:10240', // max 10MB
        ]);

        $file = $request->file('cv_pdf');


        $parser = new Parser();
        $pdf = $parser->parseFile($file->getPathname());
        $text = $pdf->getText();


        $data = $this->extractData($text);


        $prefixedData = [];
        foreach ($data as $key => $value) {
            $prefixedData['personal_' . $key] = $value;
        }


        return redirect()->back()->withInput($prefixedData)->with('success', 'CV uploaded and data extracted successfully.');
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'personal_name' => 'nullable|string|max:5000',
            'personal_last_education' => 'nullable|string|max:5000',
            'personal_organization_history' => 'nullable|string|max:5000',
            'personal_achievement_history' => 'nullable|string|max:5000',
        ]);

        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Kamu harus login terlebih dahulu.');
        }

        $userId = Auth::id();

        // Simpan atau update CV milik user
        CvData::updateOrCreate(
            ['user_id' => $userId], // kondisi pencarian
            $validated + ['user_id' => $userId] // data yang disimpan
        );

        return redirect()->back()->withInput()->with('success', 'Data CV berhasil disimpan atau diperbarui!');
    }



    public function showForm()
    {
        $cv = null;
        if (Auth::check()) {
            $cv = CvData::where('user_id', Auth::id())->first();
        }

        return view('cv.upload', compact('cv'));
    }


    private function extractData($text)
    {
        $data = [];


        $lines = preg_split('/\r\n|\r|\n/', $text);


        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                $data['name'] = $line;
                break;
            }
        }


        if (preg_match('/(Education|Pendidikan)(.*?)(Job|Internship|Projects|Achievement|Prestasi|Organization|Organisasi|$)/is', $text, $matches)) {
            $data['last_education'] = trim($matches[2]);
        }


        if (preg_match('/(Organization|Organisasi)(.*?)(Achievement|Prestasi|$)/is', $text, $matches)) {
            $data['organization_history'] = trim($matches[2]);
        }


        if (preg_match('/(Achievement|Prestasi)(.*)$/is', $text, $matches)) {
            $data['achievement_history'] = trim($matches[2]);
        }

        return $data;
    }
}
