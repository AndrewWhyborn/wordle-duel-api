<?php

declare(strict_types=1);

namespace App\Service\Round;

use App\Enum\GameStatusEnum;
use App\Enum\LetterStatusEnum;
use App\Models\Game;
use App\Models\Letter;
use App\Models\Round;
use App\Service\Word\CompareLettersServiceInterface;
use App\Type\ComparedLetterType;
use Illuminate\Support\Facades\DB;

/**
 * Служба для создания раунда.
 */
readonly class CreateRoundService
{
    /**
     * Создаст службу.
     *
     * @param CompareLettersServiceInterface $compareLettersService Служба для сравнения букв двух слов.
     */
    public function __construct(private CompareLettersServiceInterface $compareLettersService)
    {
    }

    /**
     * Создаст раунд.
     *
     * @param Game  $game    Игра.
     * @param array $letters Введенные буквы.
     *
     * @return Round
     *
     * @throws \Throwable
     */
    public function execute(Game $game, array $letters): Round
    {
        if ($game->status !== GameStatusEnum::IN_PROGRESS->value) {
            throw new \Exception('Вы закончили данную игру.');
        }

        $roundsCount
            = Round::query()->where(
                column: 'game_id',
                operator: '=',
                value: $game->id
            )
            ->count()
        ;

        $comparisons = $this->compareLettersService->execute(
            targetLetters: \mb_str_split($game->word->target),
            inputLetters: $letters
        );

        DB::beginTransaction();

        $round = new Round();
        $round->game_id = $game->id;
        $round->index = ++$roundsCount;
        $round->save();

        $successCount = 0;

        foreach ($comparisons as $comparison) {
            $letter = new Letter();
            $letter->round_id = $round->id;
            $letter->index = $comparison->index;
            $letter->value = $comparison->value;
            $letter->status = $comparison->status;
            $letter->save();

            if ($comparison->status === LetterStatusEnum::SUCCESS->value) {
                $successCount++;
            }
        }

        if ($successCount === 5) {
            $game->status = GameStatusEnum::COMPLETED->value;
            $game->save();
        } elseif ($roundsCount === 5) {
            $game->status = GameStatusEnum::FAILED->value;
            $game->save();
        }

        DB::commit();

        return $round;
    }
}
