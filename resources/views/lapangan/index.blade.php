<x-app-layout>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" />

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lapangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                

                <div class="container">
                    <div class="row">
                        <div class="d-flex justify-content-center align-items-center">


                            @foreach($courts as $court)
                        <div class="card m-4" style="width: 18rem;">
                            <img src="{{ asset('storage/' . $court['img']) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                
        
                                <div class="card-title text-center mb-3"><h3>{{ $court['name'] }}</h3></div>
                                
                                
                                <div class="card-text text-center mb-3">
                                    <p class="price text-danger">Rp. {{ number_format($court['price'], 0, ',', '.') }}/Jam</p>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jadwalModal" onclick="renderUtama(<?= json_encode($court['id']) ?>)">
                                        Jadwal
                                      </button>
                                      <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#pesanModal"  onclick="loadModalContent({{ json_encode($court) }})">
                                        Pesan
                                      </button>

                                      

                                </div>
                            </div>
                        </div>
                        @endforeach
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- Modal Pesan --}}

    <div class="modal fade" id="pesanModal" tabindex="-1" aria-labelledby="pesanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="pesanModalLabel">Pesan Lapangan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ..
            </div>
            
          </div>
        </div>
      </div>


    <!-- Modal Jadwal-->
<div class="modal fade" id="jadwalModal" tabindex="-1" aria-labelledby="jadwalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="jadwalModalLabel">Jadwal Lapangan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="utama" class="table-responsive p-0"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
  

  <script>

    const url = window.location.href.split('/');
    const baseUrl = `${url[0]}//${url[2]}/${url[3]}/`;
    const baseImgUrl = `${url[0]}//${url[2]}/storage/`;
    console.log(baseImgUrl)

    var hargaPerJam;
    
    // document ready
    window.addEventListener('DOMContentLoaded', () => {
        // renderUtama();
    });

    function updateTotal() {
        const lamaMain = document.getElementById("lama_sewa").value;

        // Calculate the total
        const totalHarga = hargaPerJam * lamaMain;

        document.getElementById("total").value = `Rp ${totalHarga}`;
    }

    function loadModalContent(court) {
        const modalBody = document.querySelector('#pesanModal .modal-body');
        console.log(court);

        hargaPerJam = court['price'];
        
        // Set the HTML content inside modal-body
        modalBody.innerHTML = `
        
            <h5 class="text-center mb-3">${court['name']}</h5>
                <div class="text-center mb-3">
                    <img src="${baseImgUrl}${court['img']}" alt="Lapangan" class="img-fluid" style="max-height: 300px; width:100%; object-fit: cover;">
                </div>
                <form method="post" action="{{ route('order.store') }}" enctype="multipart/form-data" id="orderForm" >
                    @csrf   
                    <input type="text" class="form-control" id="lapangan_id" value="${court['id']}" readonly name="lapangan_id" hidden>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="tanggal_pesan">Jam Main</label>
                        <input type="datetime-local" class="form-control" id="tanggal_pesan" name="tanggal_pesan" value="2024-09-17T20:30">
                      </div>
                      <div class="form-group col-md-6 mt-3">
                        <label for="lama_sewa">Lama Main</label>
                        <select class="form-control" id="lama_sewa" name="lama_sewa" onchange="updateTotal()">
                          <option value="1">1 Jam</option>
                          <option value="2">2 Jam</option>
                          <option value="3">3 Jam</option>
                          <option value="4">4 Jam</option>
                          <option value="5">5 Jam</option>
                        </select>
                      </div>
                    </div>
          
                    <!-- Jam Habis and Harga -->
                    <div class="row">
                        <div class="form-group col-md-6 mt-3">
                            <label for="harga">Harga/Jam</label>
                            <input type="text" class="form-control" id="harga" value="Rp ${court['price']}" readonly>
                          </div>
                      
                    </div>

                    <hr class="mt-3 mb-3">
          
                    <!-- Total -->
                    <div class="form-group">
                      <label for="total">Total</label>
                      <input type="text" class="form-control" name="total" id="total" value="Rp ${hargaPerJam}" readonly>
                    </div>
          
                    <!-- Bank Transfer Information -->
                    <div class="form-group mt-3 mb-3">
                      <label>Transfer ke : <b>BCA 66005542 a/n Ivan Prastio</b></label>
                    </div>
          
                    <!-- Upload Bukti -->
                    <div class="form-group">
                      <label for="bukti_transfer">Upload Bukti</label>
                      <input type="file" class="form-control-file" id="bukti_transfer" name="bukti_transfer">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
          
                    
                  </form>
        `;
    }

    const renderUtama = (id) => {
                document.querySelector('#utama').innerHTML = tableUtamaHTML;
                dataTableUtama(id);
            };

    function numberFormat(price) {
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(price);
    }


    const dataTableUtama = (id) => {
                $('#tableUtama').DataTable({
                    ajax: {
                        url: `${baseUrl}get_jadwal`,
                        data: {
                            id: id 
                        },
                        dataSrc: ''
                    },

                    searching: false, paging: false, info: false,
                    ordering:false,
                    columns: [
                        {"data": "id",
                        render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            'render': function (data, type, row, meta) {
                                return row.tanggal_pesan;
                            }
                        },
                        {
                            'render': function (data, type, row, meta) {
                                return row.users.name;
                            }
                        },
                        {
                            'render': function (data, type, row, meta) {
                                return row.lapangans.name;
                            }
                        },
                        {
                            'render': function (data, type, row, meta) {
                                return row.jam_pesan;
                            }
                        },

                        {
                            'render': function (data, type, row, meta) {
                                return `<p>${row.lama_sewa} Jam</p>`;
                            }
                        },

                        {
                            'render': function (data, type, row, meta) {
                                return row.lama_habis;
                            }
                        },
                    ],
                });
                // getLocation();

            };



            const tableUtamaHTML = `<table id="tableUtama" class="table align-items-center justify-content-center mb-0 cell-border">
                    <thead style="background-color: #eee">
                        <tr>
                            
                            <th
                                class="text-uppercase  text-xs font-weight-bolder p-3 text-dark">
                                No.</th>

                            <th
                                class="text-uppercase  text-xs font-weight-bolder p-3 text-dark">
                                Tanggal Pesan</th>
                            <th
                                class="text-uppercase text-xs text-dark font-weight-bolder p-3  ps-2">
                                Nama Penyewa</th>
                            <th
                                class="text-uppercase text-xs text-dark font-weight-bolder p-3  ps-2">
                                Nama Lapangan</th>
                            <th
                                class="text-uppercase text-xs text-dark font-weight-bolder p-3  ps-2">
                                Jam Main</th>

                            <th
                                class="text-uppercase text-xs text-dark font-weight-bolder p-3  ps-2">
                                Lama Sewa</th>

                            <th
                                class="text-uppercase text-xs text-dark font-weight-bolder p-3  ps-2">
                                Lama Habis</th>
                        </tr>
                    </thead>
                </table>`
  </script>
</x-app-layout>
