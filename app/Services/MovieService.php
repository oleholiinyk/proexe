<?php

namespace App\Services;


use External\Bar\Exceptions\ServiceUnavailableException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class MovieService
{
    /**
     * @var \External\Bar\Movies\MovieService
     */
    protected $barMovieService;
    /**
     * @var \External\Baz\Movies\MovieService
     */
    protected $bazMovieService;
    /**
     * @var \External\Foo\Movies\MovieService
     */
    protected $fooMovieService;

    public function __construct(
        \External\Bar\Movies\MovieService $barMovieService,
        \External\Baz\Movies\MovieService $bazMovieService,
        \External\Foo\Movies\MovieService $fooMovieService

    ) {
        $this->barMovieService = $barMovieService;
        $this->bazMovieService = $bazMovieService;
        $this->fooMovieService = $fooMovieService;
    }

    public function getTitles(): Collection
    {
        $barMovies = $this->prepareData($this->barMovieService->getTitles(), 'bar');
        $bazMovies = $this->prepareData($this->barMovieService->getTitles(), 'baz');
        $fooMovies = $this->prepareData($this->fooMovieService->getTitles(), 'foo');
        return collect()->merge([$barMovies, $bazMovies, $fooMovies]);
    }

    protected function prepareData($data, string $name)
    {
        try {
            switch ($name) {
                case 'foo':
                    $resultData = $data;
                    break;
                case 'bar':
                    foreach ($data['titles'] as $i) {
                        $resultData[] = $i['title'];
                    }
                    break;
                case 'baz':
                    $resultData = $data['titles'];
                    break;
            }
            Cache::put($name, $resultData);
            return $resultData;
        } catch (\Exception $e) {
            return ['status' => 'failure'];
        }
    }

}
