 <div class="modal fade" id="editModal{{ $cat->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header bg-light p-3">
                 <h5 class="modal-title" id="exampleModalLabel">&nbsp;</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                     id="close-modal"></button>
             </div>
             <form action="{{ route($routePrefix . '.update', $cat->id) }}" method="POST" id="add-edit-form">
                 @csrf
                 @method('PUT')
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="customername-field" class="form-label">Nama Categories</label>
                         <input type="text" name="nama" value="{{ $cat->nama }}" class="form-control"
                             placeholder="Enter name" required />
                     </div>
                     <div class="mb-3">
                         <label for="date-field" class="form-label">Status</label>
                         <select class="form-control" data-trigger name="is_active">
                             <option value="1" {{ $cat->is_active ? 'selected' : '' }}>aktif</option>
                             <option value="0" {{ !$cat->is_active ? 'selected' : '' }}>tidak aktif</option>
                         </select>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <div class="hstack gap-2 justify-content-end">
                         <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                         <button type="submit" class="btn btn-success" id="edit-btn">Update</button>
                     </div>
                 </div>
             </form>
         </div>
     </div>
 </div>
