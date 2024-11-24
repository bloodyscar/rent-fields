<x-app-layout>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" />

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container">
                    <div id="utama" class="table-responsive p-0"></div>
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

    // document ready
    window.addEventListener('DOMContentLoaded', () => {
        renderUtama();
    });


    const renderUtama = (id) => {
        document.querySelector('#utama').innerHTML = tableUtamaHTML;
        dataTableUtama();
    };

    const dataTableUtama = () => {
                $('#tableUtama').DataTable({
                    ajax: {
                        url: `${baseUrl}get_order`,
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
                                return row.lama_sewa;
                            }
                        },

                        {
                            'render': function (data, type, row, meta) {
                                return row.lama_habis;
                            }
                        },
                        {
                            'render': function (data, type, row, meta) {
                                return `<img src="${baseImgUrl}${row.bukti_transfer}" alt="bukti transfer" style="width: 50px; height: 50px">`;
                            }
                        },
                        {
                            'render': function (data, type, row, meta) {
                                // Assuming data is the value you want to check
                                return row.konfirmasi;
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

                            <th
                                class="text-uppercase text-xs text-dark font-weight-bolder p-3  ps-2">
                                Bukti Transfer</th>

                            <th
                                class="text-uppercase text-xs text-dark font-weight-bolder p-3  ps-2">
                                Konfirmasi</th>
                        </tr>
                    </thead>
                </table>`
  </script>
</x-app-layout>
