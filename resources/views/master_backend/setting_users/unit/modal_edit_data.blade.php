 <div class="modal fade" id="editModal{{ $unit->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header bg-light p-3">
                 <h5 class="modal-title" id="exampleModalLabel">&nbsp;</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                     id="close-modal"></button>
             </div>

             <form action="{{ route('units.update', $unit->id) }}" method="POST" id="serviceForm">
                 @csrf
                 @method('PUT')
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="customername-field" class="form-label">Nama Unit</label>
                         <input type="text" name="nama_unit" value="{{ $unit->nama_unit }}" class="form-control"
                             placeholder="Enter name" required />
                     </div>
                 </div>
                 <div class="modal-footer">
                     <div class="hstack gap-2 justify-content-end">
                         <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                         <button type="submit" class="btn btn-success" id="add-btn">Submit</button>
                     </div>
                 </div>
             </form>

         </div>
     </div>
 </div>
