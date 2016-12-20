<?php

namespace Canvas\Console\Commands;

use Canvas\Extensions\ThemeManager;

class Theme extends CanvasCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:theme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Canvas theme information';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $themeManager = new ThemeManager(resolve('app'), resolve('files'));
        $activeTheme = $themeManager->getTheme($themeManager->getActiveTheme());

         // Display results
        $headers = ['Theme', 'Version'];
        $data = [[$activeTheme->getName(), $activeTheme->getVersion()]];
        $this->table($headers, $data);
        $this->line(PHP_EOL);
    }
}
