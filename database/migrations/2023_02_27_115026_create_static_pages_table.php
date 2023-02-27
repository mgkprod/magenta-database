<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->longText('content');
            $table->timestamps();
        });

        $content = <<<'HTML'
            <h2 class="mb-4 text-xl font-semibold">Bienvenue</h2>

            <p class="mb-8">
                Ce site est une base de données communautaire qui référence les tracks connues du groupe MAGENTA et de leurs projets liés.<br />
                L'objectif est de garder une trace des différentes réinterprétations musicales et des tracks non publiées.<br />
                <br />
                Le site est alimenté par les contributions des membres du Discord. N'hésitez pas à
                <a href="https://bit.ly/magentadiscord" target="_blank" class="transition duration-200 ease-in-out text-gray-dark dark:text-gray-default hover:text-gray-darker dark:hover:text-gray-lighter">nous rejoindre</a>
                !<br />
            </p>

            <div class="mb-8">
                <div class="mb-2">Retrouvez MAGENTA sur les réseaux :</div>

                <ul class="grid grid-cols-1 gap-1">
                    <li>
                        <a href="https://www.facebook.com/magentamusique/" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-facebook"></i> Facebook</a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/channel/UCDJL7wvwArdhfydZR-XFtgw" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-youtube"></i> YouTube</a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/magenta.club/" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-instagram"></i> Instagram</a>
                    </li>
                    <li>
                        <a href="https://open.spotify.com/artist/5du1Lf0YKbak13Ym58jKsA" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-spotify"></i> Spotify</a>
                    </li>
                    <li>
                        <a href="https://music.apple.com/fr/artist/magenta/1482405700" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-apple"></i> Apple Music</a>
                    </li>
                    <li>
                        <a href="https://mtl.fm/magenta?fbclid=IwAR3uKDD5RqFPbpl0ziM3xub62vQQ8OC3oHWHg2-dkz_iQqwyXWbFyuHV9Aw#!/index" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fas fa-fw fa-phone"></i> WhatsApp</a>
                    </li>
                    <li>
                        <a href="https://bit.ly/magentadiscord" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fa fas fa-fw fa-phone"></i> Discord</a>
                    </li>
                </ul>
            </div>
        HTML;

        DB::table('static_pages')->insert([
            'name' => 'Home',
            'slug' => 'home',
            'content' => $content,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('static_pages');
    }
}
