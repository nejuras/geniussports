<?php

namespace App\Controller;

use App\Entity\Team;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ScheduleAndResults;

class GeniusSportController extends AbstractController
{
    public $urlSAR = "http://82.135.146.98/test-services/scheduleAndResults.php";
    public $entityManager;
    public $urlT = "http://82.135.146.98/test-services/team.php";

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/", name="genius_sport")
     */
    public function index()
    {
        $this->dataSarResults();

        return $this->render(
            'genius_sport/index.html.twig',
            [
                'matches' => $this->urlSarResults(),
                'teams' => $this->urlTeamWins(),
            ]
        );
    }

    public function dataTeamResults($teamId)
    {
        $urlTeams = $this->urlT . '?id=' . $teamId;
        $urlTJson = @file_get_contents($urlTeams);
        $urlTArray = json_decode($urlTJson, true);

        $team = $this->entityManager->getRepository(Team::class)->findTeamArray($teamId);

        if ($urlTJson == true) {
            if (!empty($team)) {

                $entity = $this->entityManager->getRepository(Team::class)->findOneBy(['teamId' => $urlTArray['id']]);

                $entity->setTeamId($urlTArray['id']);
                $entity->setName($urlTArray['name']);
                $this->entityManager->flush();

            } else {
                $entity = new Team();
                $entity->setTeamId($urlTArray['id']);
                $entity->setName($urlTArray['name']);

                $this->entityManager->persist($entity);
                $this->entityManager->flush();
            }
        }
        return $team;
    }

    public function dataSarResults()
    {
        $urlSARJson = @file_get_contents($this->urlSAR);
        $urlSARArrays = json_decode($urlSARJson, true);

        $schedulesResults = $this->entityManager->getRepository(ScheduleAndResults::class)->findArray();

        if ($urlSARJson == true) {

            if (!empty($schedulesResults)) {

                foreach ($urlSARArrays as $urlSARArray) {

                    !isset($urlSARArray['scoreB']) ? $urlSARArray['scoreB'] = null : $urlSARArray['scoreB'];
                    !isset($urlSARArray['scoreA']) ? $urlSARArray['scoreA'] = null : $urlSARArray['scoreA'];

                    $entity = $this->entityManager->getRepository(ScheduleAndResults::class)->findOneBy(['resultId' => $urlSARArray['id']]);

                    $entity->setResultId($urlSARArray['id']);
                    $entity->setTeamAId($urlSARArray['teamAId']);
                    $entity->setTeamBId($urlSARArray['teamBId']);
                    $entity->setScoreB($urlSARArray['scoreB']);
                    $entity->setScoreA($urlSARArray['scoreA']);
                    $entity->setDate($urlSARArray['date']);
                    $this->entityManager->flush();
                }
            } else {
                foreach ($urlSARArrays as $urlSARArray) {
                    !isset($urlSARArray['scoreB']) ? $urlSARArray['scoreB'] = null : $urlSARArray['scoreB'];
                    !isset($urlSARArray['scoreA']) ? $urlSARArray['scoreA'] = null : $urlSARArray['scoreA'];
                    $entity = new ScheduleAndResults();
                    $entity->setResultId($urlSARArray['id']);
                    $entity->setTeamAId($urlSARArray['teamAId']);
                    $entity->setTeamBId($urlSARArray['teamBId']);
                    $entity->setScoreB($urlSARArray['scoreB']);
                    $entity->setScoreA($urlSARArray['scoreA']);
                    $entity->setDate($urlSARArray['date']);

                    $this->entityManager->persist($entity);
                    $this->entityManager->flush();
                }
            }
        }
        return $schedulesResults;
    }
    /**
     * @Route("/sortsarresults/{sort}", name="sort_score")
     */
    public function urlSarResults($sort = '')
    {
        $json_decode = $this->dataSarResults();

        foreach ($json_decode as $key => &$value) {

            $team['teamA'] = $this->teamById($value['teamAId']);
            $value['teamAId'] = $team['teamA']['name'];

            $team['teamB'] = $this->teamById($value['teamBId']);
            $value['teamBId'] = $team['teamB']['name'];
        }
        unset($value);
//        var_dump($json_decode);
        if ($sort == 'sortDatesasc') {
            usort($json_decode, function($a, $b) {
                return $a['date'] <=> $b['date'];
            });
            return new JsonResponse($json_decode);
        }
        if ($sort == 'sortDatesdesc') {
            usort($json_decode, function($a, $b) {
                return $b['date'] <=> $a['date'];
            });
            return new JsonResponse($json_decode);
        }

        if ($sort == 'sortTeamBsasc') {;
            usort($json_decode, function($a, $b) {
                return $a['teamBId'] <=> $b['teamBId'];
            });

            return new JsonResponse($json_decode);
        }
        if ($sort == 'sortTeamBsdesc') {
            usort($json_decode, function($a, $b) {
                return $b['teamBId'] <=> $a['teamBId'];
            });

            return new JsonResponse($json_decode);
        }
        if ($sort == 'sortTeamAsasc') {;
            usort($json_decode, function($a, $b) {
                return $a['teamAId'] <=> $b['teamAId'];
            });

            return new JsonResponse($json_decode);
        }
        if ($sort == 'sortTeamAsdesc') {
            usort($json_decode, function($a, $b) {
                return $b['teamAId'] <=> $a['teamAId'];
            });

            return new JsonResponse($json_decode);
        }

        if ($sort == 'sortScoresasc') {
            usort($json_decode, function($a, $b) {
                if ($a['scoreA'] == null) return 1;
                if ($a['scoreB'] == null) return 1;
                return $a['scoreA'] <=> $b['scoreA'];
            });
            return new JsonResponse($json_decode);
        }
        if ($sort == 'sortScoresdesc') {
            usort($json_decode, function($a, $b) {
                return $b['scoreA'] <=> $a['scoreA'];
            });
            return new JsonResponse($json_decode);
        }
        return $json_decode;
    }
    /**
     * @Route("/sortteam/{sort}", name="sort_team")
     */
    public function urlTeamWins($sort = '')
    {
        $newTeamWinArray = [];
        foreach ($this->urlSarResults() as $key => &$value) {

            if (isset($value['scoreA']) && ($value['scoreB'])) {

                switch ($value['scoreA'] <=> $value['scoreB']) {
                    case '-1':
                        $newTeamWinArray[$key][$value['teamAId']] = 0;
                        $newTeamWinArray[$key][$value['teamBId']] = 1;
                        break;

                    case '1':
                        $newTeamWinArray[$key][$value['teamAId']] = 1;
                        $newTeamWinArray[$key][$value['teamBId']] = 0;
                        break;

                    case '0':
                        $newTeamWinArray[$key][$value['teamAId']] = 0;
                        $newTeamWinArray[$key][$value['teamBId']] = 0;
                        break;
                }
            }
        }
        unset($value);
        foreach ($newTeamWinArray as $row) {
            foreach ($row as $index => $val) {

                $teamWinSumArray[$index] = (isset($teamWinSumArray[$index]) ? $teamWinSumArray[$index] + $val : $val);
            }
        }
        if ($sort == 'sortWinsasc') {
            asort($teamWinSumArray);
            return new JsonResponse($teamWinSumArray);
        }
        if ($sort == 'sortWinsdesc') {
            arsort($teamWinSumArray);
            return new JsonResponse($teamWinSumArray);
        }
        if ($sort == 'sortNamedesc') {
            ksort($teamWinSumArray);
            return new JsonResponse($teamWinSumArray);
        }
        if ($sort == 'sortNameasc') {
            krsort($teamWinSumArray);
            return new JsonResponse($teamWinSumArray);
        }
        arsort($teamWinSumArray);
        return $teamWinSumArray;
    }

    public function teamById($teamId, int $wins = 0)
    {
        $json_decode = $this->dataTeamResults($teamId);
        $json_decode['wins'] = $wins;

        return array_shift($json_decode);
    }
}
