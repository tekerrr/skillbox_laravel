<?php


namespace App\Service;


class TotalReport
{
    protected $items;
    protected $report = [];

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function generate()
    {
        foreach ($this->items as $item) {
            if ($class = $this->getClass($item)) {
                $this->report[$this->getname($item)] = $class::count();
            }
        }
    }

    public function getReport(): array
    {
        return $this->report;
    }

    public function saveAsCsv(): string
    {
        $content = [
            ['Отчёт:', 'Итого'],
            ['Дата:', ($date = now())],
            [],
            ['Количество элементов:'],
        ];

        foreach ($this->report as $key => $value) {
            $content[] = [$key, $value];
        }

        $fileName = 'total-' . $date->format('Y-m-dTH-i-s') . '.csv';
        $fileFullPath = storage_path(config('admin.path.reports') . $fileName);

        $csv = \League\Csv\Writer::createFromPath($fileFullPath, 'w+');
        $csv->insertAll($content);

        return $fileFullPath;
    }

    private function getClass($item): ?string
    {
        return $this->getClasses()[$item] ?? null;
    }

    private function getName($item): string
    {
        return $this->getNames()[$item];
    }

    private function getClasses(): array
    {
        return [
            'news'     => \App\News::class,
            'posts'    => \App\Post::class,
            'comments' => \App\Comment::class,
            'tags'     => \App\Tag::class,
            'users'    => \App\User::class,
        ];
    }

    private function getNames(): array
    {
        return [
            'news'     => 'Новости',
            'posts'    => 'Статьи',
            'comments' => 'Комментарии',
            'tags'     => 'Теги',
            'users'    => 'Пользователи',
        ];
    }
}
