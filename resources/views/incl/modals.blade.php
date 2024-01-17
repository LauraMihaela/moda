<div class="modal fade" id="generic-modal" tabindex="-1" role="dialog"
 aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div id="generic-modalheader">
          <div id="head-modal" class="modal-header">
            <h4 class="modal-title"></h4>
            <div class="modalWindowButtons">
              <button type="button" class="close icon_close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <button class="close modalCollapse" style="display:none"> 
                {{-- <span aria-hidden="true"><i id="modal-icon-collapse" class="fa fa-caret-square-down"></i></span> --}}
                <span aria-hidden="true"><i id="modal-icon-collapse" class="fa-solid fa-caret-down"></i></span>
              </button>
              {{-- <button class="close modalMinimize"> 
                <span aria-hidden="true"><i class='fa fa-minus'></i> </span>
              </button> --}}
            </div>
          </div>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModal">@lang('messages.close')</button>
          <button type="submit" class="btn btn-primary" id="saveModal"><i class="fa fa-save"></i>&ensp;@lang('messages.save-changes')</button>
        </div>     
      </div>
    </div>
  
</div>

<div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog"
aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
       <div id="generic-modalheader">
         <div id="head-modal" class="modal-header">
           <h4 class="modal-title"></h4>
           <div class="modalWindowButtons">
             <button type="button" class="close icon_close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
             <button class="close modalCollapse" style="display:none"> 
               <span aria-hidden="true"><i class="fa fa-caret-square-down"></i></span>
             </button>
             {{-- <button class="close modalMinimize"> 
               <span aria-hidden="true"><i class='fa fa-minus'></i> </span>
             </button> --}}
           </div>
         </div>
       </div>
       <div class="modal-body">
         
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeConfirmModal">@lang('messages.close')</button>
         <button type="submit" class="btn btn-primary" id="okConfirmModal"><i class="fa fa-save"></i>&ensp;@lang('messages.save-changes')</button>
       </div>     
     </div>
   </div>
</div>