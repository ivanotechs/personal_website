<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Support\SiteIcon;
use Illuminate\Console\Command;

class FetchProjectIcons extends Command
{
    protected $signature = 'projects:fetch-icons';

    protected $description = 'Download a favicon or logo for every project that has a website or GitHub link';

    public function handle(SiteIcon $icons): int
    {
        $projects = Project::query()
            ->where(function ($query): void {
                $query->whereNotNull('url')->orWhereNotNull('github_url');
            })
            ->orderBy('sort')
            ->get();

        foreach ($projects as $project) {
            $source = $project->url ?: $project->github_url;
            $path = $icons->store($project);

            if ($path) {
                $this->info($project->slug.' ← '.$source);
            } else {
                $this->warn($project->slug.' · no icon from '.$source);
            }
        }

        return self::SUCCESS;
    }
}
