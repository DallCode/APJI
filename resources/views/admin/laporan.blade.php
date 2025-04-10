@extends('layout.laporan-admin')
@section('content')

<div class="container-fluid">
  <div class="row">

    <x-sidebar-admin/>

    <main class="col-md-9 ms-sm-auto col-lg-10 content">
      <h1>Dashboard</h1>

      <div class="filters mb-3">
        <form action="{{ route('laporan.export') }}" method="GET">
          <div class="row">
            <div class="col-md-4">
              <label for="tahun">Pilih Tahun:</label>
              <select name="tahun" id="tahun" class="form-control">
                @for ($i = date('Y'); $i >= 2000; $i--)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>
            </div>
            <div class="col-md-4">
              <label for="bulan">Pilih Bulan:</label>
              <select name="bulan" id="bulan" class="form-control">
                <option value="">Semua</option>
                @foreach(range(1,12) as $m)
                  <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4 mt-4">
              <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
            </div>
          </div>
        </form>
      </div>

      <div class="export-buttons mb-3">
        <a href="{{ route('laporan.export', ['format' => 'pdf']) }}" class="btn btn-danger">Export PDF</a>
        <a href="{{ route('laporan.export', ['format' => 'excel']) }}" class="btn btn-success">Export Excel</a>
        <a href="{{ route('laporan.export', ['format' => 'csv']) }}" class="btn btn-info">Export CSV</a>
      </div>

      <div class="card-container">
          <div class="card">
              <div class="card-content">
                  <h2>Total Sertifikat</h2>
                  <p>{{ $totalSertifikat }}</p>
              </div>
          </div>
          <div class="card">
              <div class="card-content">
                  <h2>Total Kelayakan</h2>
                  <p>{{ $totalKelayakan }}</p>
              </div>
          </div>
      </div>

      <div class="table">
        <div class="tableheader">
            <h6>Detail Sertifikat</h6>
        </div>
        <div class="tablecontent">
          <table>
              <thead>
                  <tr>
                      <th>Jenis</th>
                      <th>Diproses</th>
                      <th>Disetujui</th>
                      <th>Ditolak</th>
                      <th>Total</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($sertifikatData as $jenis => $data)
                  <tr>
                      <td>{{ $jenis }}</td>
                      <td>{{ $data['proses'] }}</td>
                      <td>{{ $data['diterima'] }}</td>
                      <td>{{ $data['ditolak'] }}</td>
                      <td>{{ $data['total'] }}</td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
      </div>
      
      <div class="table">
        <div class="tableheader">
            <h6>Detail Kelayakan</h6>
        </div>
        <div class="tablecontent">
          <table>
              <thead>
                  <tr>
                      <th>Jenis</th>
                      <th>Disetujui</th>
                      <th>Ditolak</th>
                      <th>Total</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($kelayakanData as $jenis => $jumlah)
                  <tr>
                    <td>{{ $jenis }}</td>
                    <td>{{ $data['proses'] }}</td>
                    <td>{{ $data['diterima'] }}</td>
                    <td>{{ $data['ditolak'] }}</td>
                    <td>{{ $data['total'] }}</td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</div>
@endsection
