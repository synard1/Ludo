<!-- Modal -->
<div class="modal fade" id="kt_modal_signaturepad" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div id="signature-pad" class="signature-pad">
                    <div class="signature-pad--body">
                        <!-- Hidden div to dynamically append input fields -->
                        <div id="hiddenInputFields"></div>
                        <canvas></canvas>
                    </div>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning clear">Clear</button>
        <button type="button" class="btn btn-success save">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
