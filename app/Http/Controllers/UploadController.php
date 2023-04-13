<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->files->get('file');

        // Open the CSV file and read the data
        $csv = array_map('str_getcsv', file($file));
        $data = array_slice($csv, 1);

        $people = [];
        foreach ($data as $personString) {
            $titles = ["Mr", "Mrs", "Mister", "Dr", "Prof", "Ms"];
            $title = null;
            $initial = null;
            $firstName = null;
            $lastName = null;

            $personString = $personString[0];

            // replace & with and
            $personString = str_replace('&', 'and', $personString);
    
            // Handle strings containing "and"
            if (strpos($personString, " and ") !== false) {
                $personStrings = explode(" and ", $personString);
            } else {
                $personStrings = [$personString];
            }

            foreach ($personStrings as $personString) {
                // Split into words
                $words = explode(" ", $personString);
                // Get title
                foreach ($titles as $possibleTitle) {
                    if (in_array($possibleTitle, $words)) {
                        $title = $possibleTitle;
                        $words = array_values(array_diff($words, [$title]));
                        break;
                    }
                }
    
                // Get initial
                if (isset($words[0]) && preg_match("/^[A-Z]\.?$/", $words[0])) {
                    $initial = $words[0];
                    $words = array_slice($words, 1);
                }
    
                // Get first and last name
                if (count($words) > 1) {
                    // dd($words);
                    $firstName = array_shift($words);
                    $lastName = array_pop($words);
                    if (count($words) > 0) {
                        $firstName .= " " . implode(" ", $words);
                    }
                } elseif (count($words) == 1) {
                    $lastName = $words[0];
                }
    
                // Store person
                if ($title !== null && $lastName !== null) {
                    $people[] = [
                        "title" => $title,
                        "initial" => $initial,
                        "first_name" => $firstName,
                        "last_name" => $lastName,
                    ];
                }
            }
        }


        return Inertia::render('FileUpload', [
            'people' => $people
          ]);
    
    }
}


