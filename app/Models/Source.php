<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Source extends Model
{
    protected $fillable = [
        'source_title',
        'section_title',
        'publication_year',
        'publisher',
        'publisher_place',
        'contributors',
    ];

    protected $casts = [
        'contributors' => 'array',
    ];

    public static $contributorTypes = [
        'source_author' => 'Source Author',
        'section_author' => 'Section Author',
        'translator' => 'Translator',
        'editor' => 'Editor',
    ];

    protected function internalTitle(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->source_title) {
                    return $this->source_title;
                } elseif ($this->id) {
                    return "#$this->id";
                } else {
                    return 'New Source';
                }
            },
        );
    }

    protected function citation(): Attribute
    {
        return Attribute::make(
            get: function () {
                $citation = '';
                $authors = $this->getCommaSeparatedContributors('source_author');

                if ($authors) {
                    $citation .= "$authors. ";
                }

                if ($this->source_title) {
                    $citation .= "<i>$this->source_title</i>. ";
                }

                if ($this->publisher_place) {
                    $citation .= $this->publisher_place
                        . ($this->publisher
                            ? ': '
                            : ($this->publication_year !== null
                                ? ', '
                                : '. '
                            )
                        );
                }

                if ($this->publisher) {
                    $citation .= $this->publisher
                        . ($this->publication_year !== null
                            ? ', '
                            : '. '
                        );
                }

                if ($this->publication_year !== null) {
                    $citation .= "$this->publication_year. ";
                }

                return $citation;
            },
        );
    }

    public function getCommaSeparatedContributors(string $type): string
    {
        $contributors = collect($this->contributors)->filter(fn ($c) => $c['type'] === $type);

        return (string) $contributors->map(
            fn ($c) => (!empty($c['last_name'])
                ? $c['last_name'] . ', '
                : ''
            )
            . (!empty($c['first_name']) ? $c['first_name'] : '')
        )
        ->sort()
        ->reduce(
            fn ($a, $e, $i) => $a . ($i > 0 ? ($i === $contributors->count() - 1 ? ' and ' : ', ') : '') . $e
        );
    }
}
