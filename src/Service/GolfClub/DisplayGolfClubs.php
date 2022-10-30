<?php

declare(strict_types=1);

namespace App\Service\GolfClub;

use App\Entity\GolfClub;
use App\Repository\GolfClubRepository;

class DisplayGolfClubs
{
    private GolfClubRepository $golfClubRepository;

    /**
     * @param GolfClubRepository $golfClubRepository
     */
    public function __construct(GolfClubRepository $golfClubRepository)
    {
        $this->golfClubRepository = $golfClubRepository;
    }

    public function mapGolfClubsForListing()
    {
        $golfClubs = $this->golfClubRepository->getAllEntries();

        return $golfClubs;
    }
}
