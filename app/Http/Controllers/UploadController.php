<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {

        $file = $request->files->get('file');

        // Open the CSV file and read the data
        $csv = array_map('str_getcsv', file($file));
        $data = array_slice($csv, 1);

        $people = [];
        // Loop through the CSV data and create records for each person
        foreach ($data as $row) {
            // Split the name into title and last name
            $name_parts = explode(' ', $row[0]);
            $last_name = array_pop($name_parts);
            $title = implode(' ', $name_parts);

            // Check if the title contains "and" or "&"
            if (strpos($title, ' and ') !== false || strpos($title, ' & ') !== false) {
                // If the title contains "and" or "&", create records for each person
                $names = preg_split('/\s+and\s+|\s+&\s+/', $title);
                foreach ($names as $name) {

                    $person = $this->createPersonRecord($name, $last_name);
                    $people[] = $person;
                }
            } else {
                // If the title does not contain "and" or "&", create a record for the person
                $person = $this->createPersonRecord($title, $last_name);
                $people[] = $person;
            }
        }

        // Return people array
        return redirect()->back()->with([
            'message' => 'Installer was successfully deleted',
        ]);
       // return response()->json(['data' => $people]);
    }
    private function createPersonRecord($title, $last_name) {
        // Split the title into title and initial (if applicable)
        $title_parts = explode(' ', $title);
        $initial = null;
        $first_name = null;
        if (count($title_parts) > 1) {
            $first_name = array_pop($title_parts);
            $initial = substr($first_name, 0, 1);
        }
        $title = implode(' ', $title_parts);
    
        // Create a new Person record
        $person = [
            'title' => $title,
            'initial' => $initial,
            'first_name' => $first_name,
            'last_name' => $last_name,
        ];
        return $person;
    }
}


