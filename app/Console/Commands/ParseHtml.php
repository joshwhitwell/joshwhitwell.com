<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParseHtml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-html';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = storage_path('app/public/ppl.csv');
        $handle = fopen($path, 'r');
        $json = [];

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            if (strpos($row[0], 'Week') !== false) {
                if (!isset($headers)) {
                    $headers = $row;
                    $headers[2] = 'Exercise Link';
                    $headers[8] = 'header 8';
                    $headers[9] = 'header 9';
                    $headers[10] = 'header 10';
                    $headers[15] = 'Substitution Option 1 Link';
                    $headers[17] = 'Substitution Option 2 Link';
                    $headers = array_map(function ($header) {
                        return strtolower(str_replace([' ', '-'], '_', $header));
                    }, $headers);
                }

                $currentWeek = $row[0];

                if (!isset($json[$currentWeek])) {
                    $json[$currentWeek] = [];
                }

                continue;
            } elseif (!empty($row[0])) {
                $currentDay = $row[0];

               if (!isset($json[$currentWeek][$currentDay])) {
                    $json[$currentWeek][$currentDay] = [];
                }
            }

            if (!empty($row[1])) {
                $row = array_combine($headers, $row);
                $row['exercise_key'] = \Str::of($row['exercise'])->replace('-', ' ')->snake()->toString();
                $row['warm_up_sets'] = (int) max(explode('-', $row['warm_up_sets']));
                $row['working_sets'] = (int) max(explode('-', $row['working_sets']));
                $json[$currentWeek][$currentDay][] = $row;
            }
        }

        file_put_contents(storage_path('app/public/pure-bodybuilding.json'), json_encode($json, JSON_PRETTY_PRINT));

        fclose($handle);
    }
}
