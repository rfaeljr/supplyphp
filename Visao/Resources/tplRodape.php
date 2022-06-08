<!-- rodapé -->
<script type="text/javascript">
   /*window.onload = function () {    
    var xHtmlId = jQuery('#sessao_tempo');
    relogio(600, jQuery('#sessao_tempo'));
   };
   
   document.body.onclick = function(){
     
   };*/
</script>
<div class="row">
    <footer class="page-footer">
        <div class="footer-copyright"> 
            © <?php echo(date( "Y" )); ?> Copyright BRK Ambiental 
			<span style='margin-left: 300px;'>versão 1.2 de 26/09/2018</span>
            <div class="grey-text text-lighten-4 right fonte10px" id="usuario"/>            
            <?php echo(Funcoes::getMatriculaNomeUsuario()); ?>
            <!-- [<b style='color: black;'><span id='sessao_tempo'></span></b>] -->
        </div>
    </footer>            
</div>

