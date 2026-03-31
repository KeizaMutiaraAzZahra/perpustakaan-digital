@extends('layouts.main')

@section('title', 'Data Anggota')

@section('content')

 <main class="frame-main">
      <section class="data-anggota-kepala">

        <h1 class="title">Data Anggota</h1>
        
        <!-- Search Bar -->
        <div class="search-container" role="search">
          <div class="rectangle">
            <img class="zoom-in" src="img/zoom-in.svg" alt="Search icon" />
            <label for="search-input" class="sr-only">Cari Anggota</label>
            <input id="search-input" class="div" type="search" placeholder="Cari Anggota" aria-label="Cari Anggota" />
          </div>
          <button class="rectangle-2" type="button" aria-label="Cari">
            <span class="text-wrapper-2">Cari</span>
          </button>
        </div>
        <!-- Data Table -->
        <div class="table-container rectangle-3" role="region" aria-label="Data Anggota">
          <!-- Table Header -->
          <div class="table-header" aria-hidden="true">
            <span class="text-wrapper-3">No</span>
            <span class="text-wrapper-4">Nama</span>
            <span class="text-wrapper-5">Kelas</span>
            <span class="text-wrapper-6">Jurusan</span>
            <span class="text-wrapper-7">No_telepon</span>
            <span class="text-wrapper-8">Tgl. Daftar</span>
            <span class="text-wrapper-9">Status</span>
          </div>
          <hr class="line-2" aria-hidden="true" />
          <!-- Table Body -->
          <div class="table-body rectangle-4">
            <!-- Row 1 -->
            <div class="table-row">
              <hr class="line-3" aria-hidden="true" />
              <div class="row-status">
                <div class="rectangle-5">
                  <span class="text-wrapper-10">Aktif</span>
                </div>
              </div>
            </div>
            <!-- Row 2 -->
            <div class="table-row">
              <hr class="line-4" aria-hidden="true" />
              <div class="row-status">
                <div class="rectangle-6">
                  <span class="text-wrapper-11">Nonaktif</span>
                </div>
              </div>
            </div>
            <!-- Row 3 (empty) -->
            <div class="table-row table-row--empty"></div>
          </div>
        </div>
      </section>
    </main>
@endsection