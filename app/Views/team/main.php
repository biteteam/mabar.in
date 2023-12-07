 <?= $this->extend('layouts/layout') ?>

 <?= $this->section('content') ?>
 <div class="w-full relative">
     <div class="mt-4 md:mt-0 md:mb-6">
         <a class="text-xs lg:text-sm text-center w-auto py-1.5 px-4 font-medium rounded-md border transition focus:outline-none bg-vulcan-600 border-transparent bg-bg-vulcan-400/80 text-slate-200 hover:bg-vulcan-500 hover:border-vulcan-500 hover:text-white cursor-pointer"
            href="<?= url_to('team.add') ?>">
             <span class="inline">
                 <i class="fa-solid fa-plus mr-0.5"></i>
                 Buat Tim
             </span>
         </a>
     </div>

     <div class="flex flex-col w-full mt-8 sm:mt-3 md:mt-4 gap-8 md:gap-12">
         <div class="flex flex-col w-full">
             <h2 class="text-lg font-medium leading-6 text-slate-100">Gabung ke tim berikut</h2>
             <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
             </div>

             <div class="flex w-full justify-center text-center py-2 md:py-8">
                 <span class="text-sm font-medium text-slate-400">Upps, Belum Ada tim yang terbentuk. <a class="text-blue-400"
                        href="<?= url_to('team.add') ?>">Buat
                         Tim Yuk!</a></span>
             </div>
         </div>
     </div>
 </div>
 <?= $this->endSection() ?>
