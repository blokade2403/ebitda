 <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header bg-light p-3">
                 <h5 class="modal-title" id="exampleModalLabel">&nbsp;</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                     id="close-modal"></button>
             </div>
             <form action="{{ route($routePrefix . '.store') }}" method="POST" id="add-edit-form">
                 @csrf
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="customername-field" class="form-label">Nama Categories</label>
                         <input type="text" name="nama" class="form-control" placeholder="Enter name" required />
                     </div>

                     <div class="mb-3">
                         <label for="parent-field" class="form-label">Parent</label>
                         <select class="form-control" data-trigger name="parent_id">
                             <option value="">Select Parent</option>
                             @foreach ($parents as $cat)
                                 <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                             @endforeach
                         </select>
                     </div>


                     <div class="mb-3">
                         <label for="productname-field" class="form-label">Kelompok Categories</label>
                         <select class="form-control" data-trigger name="kelompok">
                             <option value="DOC Variable">DOC Variable</option>
                             <option value="DOC Fixed">DOC Fixed</option>
                             <option value="IOC">IOC</option>
                         </select>
                     </div>

                     <div class="mb-3">
                         <label for="date-field" class="form-label">Status</label>
                         <select class="form-control" data-trigger name="is_active">
                             <option value="1">aktif</option>
                             <option value="0">tidak aktif</option>
                         </select>
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
