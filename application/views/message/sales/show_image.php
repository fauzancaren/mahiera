<div class="modal fade" id="modal-view">
   <div class="modal-dialog modal-fullscreen">
      <div class="modal-content" name="form-action" style="background: transparent;">
         <div class="modal-header" style="border-bottom: none;">
            <h6 class="modal-title text-white" id="modal-filename"></h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body d-flex justify-content-center align-items-center" id="modal-content" style="background: transparent;">
            <div class="panzoom" id="panzoom-element"><img src="<?= $src ?>" style="object-fit: contain;max-width: 100%;height: 100%;" /></div>
         </div>
         <div class="action-zoom">
            <a id="zoom-in"><i class="fas fa-search-plus"></i></a>
            <a id="zoom-out"><i class="fas fa-search-minus"></i></a>
            <a id="reset"><i class="fas fa-undo-alt"></i></a>
         </div>
      </div>
   </div>
</div>
<script>
   var elem = document.getElementById('panzoom-element');
   var zoomInButton = document.getElementById('zoom-in');
   var zoomOutButton = document.getElementById('zoom-out');
   var resetButton = document.getElementById('reset');
   var panzoom = Panzoom(elem, {
      maxZoom: 1,
      minZoom: 0.1,
      bounds: true,
      boundsPadding: 0.1,
      startTransform: "scale(0.1)" // +10%
   });
   var parent = elem.parentElement;
   // No function bind needed
   //parent.addEventListener('wheel', panzoom.zoomWithWheel);
   zoomInButton.addEventListener('click', panzoom.zoomIn);
   zoomOutButton.addEventListener('click', panzoom.zoomOut);
   resetButton.addEventListener('click', function() {
      panzoom.pan(0, 0);
      panzoom.zoom(0.5, {
         animate: true
      });
   });
   $("#modal-content").click(function(e) {
      if ($(e.target).parents(".panzoom").length === 0) {
         $("#modal-view").modal("hide");
      }
   });
   panzoom.zoom(0.5, {
      animate: true
   })
</script>