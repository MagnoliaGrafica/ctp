<?php get_header(); ?>

<section class="bg-cover no-repeat bg-top h-[42rem]" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/cerdito4b.webp'); ">
  <div class="container mx-auto pt-96">
    <h2 class="font-ubuntu text-7xl text-white">Tenemos los mejores convenios para ti.</h2>
  </div>
</section>

<section class="container mx-auto grid grid-cols-4 gap-8 py-32 max-w-6xl">
  <div class="text-center">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sello_verde.webp" alt="Logo" class="h-40 inline-block">
  </div>
  <div class="text-center font-ubuntu text-gray-600 col-span-3">
    <h2 class="text-xl  py-5 text-magenta">¿Quiénes somos?</h2>
    <h1 class="text-6xl text-negro">Somos <span class="font-bold text-transparent bg-clip-text bg-gradient-to-r to-verde from-verde/50">Cuida tu plata</span></h1>
    <p class="text-xl py-6 ">una empresa comprometida con el bienestar de los trabajadores y sus familias. Nacimos para ser un puente entre las necesidades de los trabajadores sindicalizados y soluciones reales que marquen una diferencia en su día a día.</p>
    <button class="bg-verde text-white text-center py-2 px-4 rounded-md shadow-md">Conócenos</button>
  </div>  
</section>

<section class="bg-verde p-[7rem]">
  <div class="container mx-auto text-white">
    <p class="text-7xl text-center px-36">Negociamos beneficios para los trabajadores</p>
  </div>
</section>
<section class="container mx-auto grid grid-cols-2 -mt-32">
  <div>
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/super1.webp" alt="imagen mujer super" >
  </div>
  <div class="pt-64 pr-32">
    <h3 class="text-negro text-5xl font-bold font-ubuntu py-4 ">Conoce nuestros<br>convenios y beneficios</h3>
    <p class="text-gray-700 py-6 ">Lorem fistrum por la gloria de mi madre esse jarl aliqua llevame al sircoo. De la pradera ullamco qué dise usteer está la cosa muy malar.</p>
    <ul>
      <li>Original Brand</li>
      <li>High Quality</li>
      <li>Trendy Style</li>
      <li>Saving Money</li>
    </ul>

    <button class="bg-verde text-white text-center py-2 px-4 rounded-md shadow-md">Contáctanos</button>
  </div>


</section>
<section>convenios</section>

<h1>
  <?php bloginfo('name'); ?>
</h1>
<p>
  <?php bloginfo('description'); ?>
</p>



<?php get_footer(); ?>
