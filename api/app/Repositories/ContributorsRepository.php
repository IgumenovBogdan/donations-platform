<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\UpdateContributorSettingsRequest;
use Illuminate\Http\Request;

class ContributorsRepository
{
    public function getContributorSettings(Request $request): array
    {
        return $request->user()->contributor->settings;
    }

    public function updateContributorSettings(UpdateContributorSettingsRequest $request): array
    {
        $contributor = $request->user()->contributor;
        $contributor->settings = $request->settings;
        $contributor->save();
        return $contributor->settings;
    }
}
