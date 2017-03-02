<?php

namespace Canvas\Console\Commands;

class Version extends CanvasCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Currently installed version of Canvas';

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
        $this->comment($this->canvasVersion());
    }
}
