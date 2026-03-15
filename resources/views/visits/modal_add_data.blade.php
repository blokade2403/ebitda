 <!--  Large modal example -->
 <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myLargeModalLabel">Form Input</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                 </button>
             </div>
             <div class="col-lg-12">
                 <div class="card-body">
                     <div class="d-flex flex-wrap justify-content-evenly">
                         <p class="text-muted mb-0"><i
                                 class="mdi mdi-numeric-1-circle text-success fs-18 align-middle me-2 rounded-circle shadow"></i>Completed
                         </p>
                         <p class="text-muted mb-0"><i
                                 class="mdi mdi-numeric-3-circle text-info fs-18 align-middle me-2 rounded-circle shadow"></i>In
                             Progress</p>
                         <p class="text-muted mb-0"><i
                                 class="mdi mdi-numeric-2-circle text-primary fs-18 align-middle me-2 rounded-circle shadow"></i>To
                             Do</p>
                     </div>
                 </div>
                 <div class="progress animated-progress bg-soft-primary rounded-bottom rounded-0" style="height: 6px;">
                     <div class="progress-bar bg-success rounded-0" role="progressbar" style="width: 30%"
                         aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                     <div class="progress-bar bg-info rounded-0" role="progressbar" style="width: 50%"
                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                     <div class="progress-bar rounded-0" role="progressbar" style="width: 20%" aria-valuenow="20"
                         aria-valuemin="0" aria-valuemax="100"></div>
                 </div>
             </div>

             <div class="modal-body">
                 <div class="alert alert-warning">
                     <h6 class="fs-15">Penginputan Data Revenue Berdasarkan Kategori</h6>
                     <div class="d-flex">
                         <div class="flex-shrink-0">
                             <i class="ri-checkbox-circle-fill text-success"></i>
                         </div>
                         <div class="flex-grow-1 ms-2">
                             <p class="text-muted mb-0">Pilih Kategori Revenue Aktual Pelayanan Pada masing-masing Unit.
                             </p>
                         </div>
                     </div>
                     <div class="d-flex mt-2">
                         <div class="flex-shrink-0">
                             <i class="ri-checkbox-circle-fill text-success"></i>
                         </div>
                         <div class="flex-grow-1 ms-2 ">
                             <p class="text-muted mb-0">Dan pilih jasa layanan sesuai dengan kategori yang revenue
                                 dipilih. </p>
                         </div>
                     </div>
                 </div>

                 <h6 class="fs-16 my-3">Form Input Aktual Revenue</h6>
                 <form method="POST" action="{{ route('visits.store') }}">
                     @csrf
                     <input type="hidden" name="tanggal" class="form-control" required>
                     <div class="col-lg-12 mb-3">
                         <label class="form-label">Pilih Kategori Revenue</label>
                         <select class="form-control" id="revenue_category_id">
                             <option value="">-- Pilih Kategori Revenue --</option>
                             @foreach ($revenu_categories as $row)
                                 <option value="{{ $row->id }}">
                                     {{ $row->nama }}
                                 </option>
                             @endforeach
                         </select>
                     </div>

                     <div class="col-lg-12 mb-3">
                         <label class="form-label">Pilih Jasa Layanan</label>
                         <select class="form-control" name="service_id" id="service_id">
                             <option value="">-- Pilih Jasa Layanan --</option>

                             @foreach ($services as $service)
                                 <option value="{{ $service->id }}"
                                     data-category="{{ $service->revenue_category_id }}">
                                     {{ $service->nama_layanan }}
                                     (Rp {{ number_format($service->tarif, 0, ',', '.') }})
                                 </option>
                             @endforeach

                         </select>
                     </div>
                     <div class="col-lg-12 mb-3">
                         <label class="form-label">Jumlah Pasien</label>
                         <input type="number" name="jumlah_pasien" class="form-control" required>
                     </div>
             </div>
             <div class="modal-footer">
                 <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i
                         class="ri-close-line me-1 align-middle"></i> Close</a>
                 <button type="submit" class="btn btn-primary ">Save changes</button>
             </div>
             </form>
         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->
