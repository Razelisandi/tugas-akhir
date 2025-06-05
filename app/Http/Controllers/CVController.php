<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class CVController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'cv_pdf' => 'required|file|mimes:pdf|max:10240', // max 10MB
        ]);

        $file = $request->file('cv_pdf');

        // Parse PDF
        $parser = new Parser();
        $pdf = $parser->parseFile($file->getPathname());
        $text = $pdf->getText();

        // Extract fields using simple regex or keyword matching
        $data = $this->extractData($text);

        // Prefix keys with 'personal_' to avoid collision with profile info form
        $prefixedData = [];
        foreach ($data as $key => $value) {
            $prefixedData['personal_' . $key] = $value;
        }

        // Redirect back with extracted data to pre-fill form fields
        return redirect()->back()->withInput($prefixedData)->with('success', 'CV uploaded and data extracted successfully.');
    }

    private function extractData($text)
    {
        $data = [];

        // Split text into lines
        $lines = preg_split('/\r\n|\r|\n/', $text);

        // Extract Name as first non-empty line
        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                $data['name'] = $line;
                break;
            }
        }

        // Extract Education block
        if (preg_match('/(Education|Pendidikan)(.*?)(Job|Internship|Projects|Achievement|Prestasi|Organization|Organisasi|$)/is', $text, $matches)) {
            $data['last_education'] = trim($matches[2]);
        }

        // Extract Organization block
        if (preg_match('/(Organization|Organisasi)(.*?)(Achievement|Prestasi|$)/is', $text, $matches)) {
            $data['organization_history'] = trim($matches[2]);
        }

        // Extract Achievement block
        if (preg_match('/(Achievement|Prestasi)(.*)$/is', $text, $matches)) {
            $data['achievement_history'] = trim($matches[2]);
        }

        return $data;
    }
}
