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
                <div class="p-6 text-gray-900">
                    {{ __("Lapangans") }}
                </div>

                <div class="container">
                    <div class="row">
                        <div class="d-flex justify-content-center align-items-center">


                            @foreach($courts as $court)
                        <div class="card m-4" style="width: 18rem;">
                            <div class="card-body">
                                <img src="{{ asset('storage/' . $court['img']) }}" class="card-img-top" alt="...">
        
                                <div class="card-title text-center mb-3"><h3>{{ $court['name'] }}</h3></div>
                                
                                
                                <div class="card-text text-center mb-3">
                                    <p class="price text-danger">Rp. {{ number_format($court['price'], 0, ',', '.') }}/Jam</p>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jadwalModal" onclick="renderUtama(<?= json_encode($court['id']) ?>)">
                                        Jadwal
                                      </button>
                                    <a href="#" class="btn btn-warning">Pesan</a>
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


    <!-- Modal -->
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
          <button type="button" class="btn btn-primary">Save changes</button>
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
    console.log(baseUrl)
    
    // document ready
    window.addEventListener('DOMContentLoaded', () => {
        // renderUtama();
    });

    const renderUtama = (id) => {
                document.querySelector('#utama').innerHTML = tableUtamaHTML;
                dataTableUtama(id);
            };


    const dataTableUtama = (id) => {
                $('#tableUtama').DataTable({
                    ajax: {
                        url: `${baseUrl}get_jadwal`,
                        data: {
                            id: id // Pass the id parameter here
                        },
                        dataSrc: ''
                    },

                    searching: false, paging: false, info: false,

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
                                return row.lama_sewa;
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
