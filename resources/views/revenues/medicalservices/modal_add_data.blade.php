 <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header bg-light p-3">
                 <h5 class="modal-title" id="exampleModalLabel">&nbsp;</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                     id="close-modal"></button>
             </div>

             <form action="{{ route('medical_services.store') }}" method="POST" id="serviceForm">
                 @csrf

                 <div class="modal-body">

                     <div class="mb-3">
                         <label class="form-label">Unit</label>
                         <select name="unit_id" class="form-control" required>
                             <option value="">Pilih Unit</option>

                             @foreach ($units as $unit)
                                 <option value="{{ $unit->id }}">
                                     {{ $unit->nama_unit }}
                                 </option>
                             @endforeach

                         </select>
                     </div>


                     <div class="mb-3">
                         <label class="form-label">Kategori Revenue</label>
                         <select name="revenue_category_id" class="form-control" required>

                             <option value="">Pilih Kategori</option>

                             @foreach ($categories as $cat)
                                 <option value="{{ $cat->id }}">
                                     {{ $cat->nama }}
                                 </option>
                             @endforeach

                         </select>
                     </div>


                     <div class="mb-3">
                         <label class="form-label">Nama Layanan</label>
                         <input type="text" name="nama_layanan" class="form-control"
                             placeholder="Contoh: Konsultasi Dokter" required>
                     </div>


                     <div class="mb-3">
                         <label class="form-label">Tarif</label>
                         <input type="number" name="tarif" class="form-control" placeholder="Masukkan tarif"
                             required>
                     </div>


                     <div class="mb-3">
                         <label class="form-label">Status</label>
                         <select name="is_active" class="form-control">
                             <option value="1">Aktif</option>
                             <option value="0">Tidak Aktif</option>
                         </select>
                     </div>

                 </div>


                 <div class="modal-footer">

                     <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                         Close
                     </button>

                     <button type="submit" class="btn btn-success">
                         Simpan
                     </button>

                 </div>

             </form>

         </div>
     </div>
 </div>
