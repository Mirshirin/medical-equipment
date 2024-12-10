<?php
//dd( $results);


?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>جستجو در تجهیزات</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css'>
<link rel="stylesheet" href="{{ asset('home/css/style.css') }}?v=1.0.1">

<link rel="stylesheet" href="{{ asset('home/css/style.less') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>

<!-- partial:index.partial.html -->
<form action="{{ url('/search') }}" method="GET" id="header-search-people" class="form-area" novalidate="novalidate" autocomplete="off">
@csrf  
<div class="row">
      <div class="col-md-10">
          <div class="styled-input wide multi">
              <div class="first-name" id="input-first-name">
                    
                  <input type="text" name="equipment_name" id="fn" value="{{ request('equipment_name') }}" autocomplete="off" data-placeholder-focus="false" required />
                  <label> نام وسیله</label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
              <div class="last-name" id="input-last-name">
                  <input type="text" name="device_model" id="ln" value="{{ request('device_model') }}" autocomplete="off" data-placeholder-focus="false" required />
                  <label>مدل وسیله</label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
              <div class="supplier_company_id" id="select-state">
                  <select name="supplier_company_id">
                      <option value="All">All</option>
                        @foreach($supplierCompanies as $supplierCompany)
                        <option value="{{ $supplierCompany->id }}" {{ request('supplier_company_id') == $supplierCompany->id ? 'selected' : '' }}>{{ $supplierCompany->name }}</option>
                        @endforeach    
                  </select>
                  <label>شرکت تامین کننده</label>
                  <svg class="chevron-down" width="17px" height="10px" viewBox="0 0 17 10" version="1.1" xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <g id="UI-Elements-Forms" transform="translate(-840.000000, -753.000000)" stroke="#4A4A4A" stroke-width="0.9">
                              <g id="Done-Copy-2" transform="translate(622.000000, 727.000000)">
                                  <polyline id="Rectangle-16" transform="translate(226.400000, 27.400000) rotate(-45.000000) translate(-226.400000, -27.400000) "
                                      points="231.8 32.8 221 32.8 221 22"></polyline>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
              
              
          </div>
      </div>
 
       
      <div class="col-md-2 no-pad-left-10">   
          <button type="submit" class="primary-btn serach-btn" id="submit_btn">SEARCH</button>
      </div>
  </div>

  <div class="row">
      <div class="col-md-10">
          <div class="styled-input wide multi">
              <div class="first-name" id="input-first-name">  
              <select name="supplier_status_is" id="supplier_status_is">
                    <option value="All" {{ request('supplier_status_is') == 'All' ? 'selected' : '' }}>All</option>
                    <option value="تولید کننده" {{ request('supplier_status_is') == 'تولید کننده' ? 'selected' : '' }}>تولید کننده</option>
                    <option value="وارد کننده" {{ request('supplier_status_is') == 'وارد کننده' ? 'selected' : '' }}>وارد کننده</option>
                    <option value="توزیع کننده" {{ request('supplier_status_is') == 'توزیع کننده' ? 'selected' : '' }}>توزیع کننده</option>
                    <option value="فروشنده" {{ request('supplier_status_is') == 'فروشنده' ? 'selected' : '' }}>فروشنده</option>
                </select>
    
                  <label>  تامین کننده </label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
              <div class="last-name" id="input-last-name">
                  <input type="text" name="status" id="ln" value="{{ request('status') }}" autocomplete="off" data-placeholder-focus="false" required />
                  <label>وضعیت </label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
              <div class="city" id="input-city">
                  <input type="text" name="history_working" id="city"  value="{{ request('history_working') }}" autocomplete="off" data-placeholder-focus="false" />
                  <label>سابقه همکاری</label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
            
              <div class="city" id="input-city">
                  <input type="text" name="query_price" id="city"  value="{{ request('query_price') }}" autocomplete="off" data-placeholder-focus="false" />
                  <label>قیمت استعلامی</label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
              <div class="brand_id" id="select-state">
                    <select name="brand_id" id="brand-select">
                      <option value="All">All</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach    
                    </select>
                  <label>برند</label>
                  <svg class="chevron-down" width="17px" height="10px" viewBox="0 0 17 10" version="1.1" xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <g id="UI-Elements-Forms" transform="translate(-840.000000, -753.000000)" stroke="#4A4A4A" stroke-width="0.9">
                              <g id="Done-Copy-2" transform="translate(622.000000, 727.000000)">
                                  <polyline id="Rectangle-16" transform="translate(226.400000, 27.400000) rotate(-45.000000) translate(-226.400000, -27.400000) "
                                      points="231.8 32.8 221 32.8 221 22"></polyline>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
          </div>
      </div>
      <div class="col-md-2 no-pad-left-10">
      <button type="submit" class="primary-btn serach-btn" id="submit_btn">

        <a href="{{ route('export-equipments') }}?{{ http_build_query(request()->all()) }}" class="primary-btn serach-btn" style=" color: white;" >Excel</a>
        </button>
    </div>
  </div>

  <div class="row">
      <div class="col-md-10">
          <div class="styled-input wide multi">
              <div class="first-name" id="input-first-name">                    
                  <input type="date" name="query_date" id="date" value="{{ request('query_date') }}" autocomplete="off" data-placeholder-focus="false" required />
                  <label> تاریخ استعلام</label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
              <div class="last-name" id="input-last-name">
                  <input type="text" name="purchase_price" id="ln"  value="{{ request('purchase_price') }}" autocomplete="off" data-placeholder-focus="false" required />
                  <label>قیمت خرید</label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
              <div class="city" id="input-city">
                  <input type="date" name="purchase_date" id="date" value="{{ request('purchase_date') }}" autocomplete="off" data-placeholder-focus="false" />
                  <label>تاریخ خرید</label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
             
              <div class="city" id="input-city">
                  <input type="text" name="salesman_agent" id="city"   value="{{ request('salesman_agent') }}" autocomplete="off" data-placeholder-focus="false" />
                  <label>   نماینده فروش</label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
              <div class="state" id="select-state">
                  <select name="medical_specialties_id"  id="medical_specialties-select">
                      <option value="All">All</option>
                        @foreach($medicalSpecialties as $specialty)
                            <option value="{{ $specialty->id }}" {{ request('medical_specialties_id') == $specialty->id ? 'selected' : '' }}>{{ $specialty->name }}</option>
                        @endforeach
             
              
                  </select>
                  <label>تخصص</label>
                  <svg class="chevron-down" width="17px" height="10px" viewBox="0 0 17 10" version="1.1" xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <g id="UI-Elements-Forms" transform="translate(-840.000000, -753.000000)" stroke="#4A4A4A" stroke-width="0.9">
                              <g id="Done-Copy-2" transform="translate(622.000000, 727.000000)">
                                  <polyline id="Rectangle-16" transform="translate(226.400000, 27.400000) rotate(-45.000000) translate(-226.400000, -27.400000) "
                                      points="231.8 32.8 221 32.8 221 22"></polyline>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
          </div>
      </div>
     
  </div>
  <div class="row">
      <div class="col-md-10">
          <div class="styled-input wide multi">
              <div class="first-name" id="input-first-name">
                    
                  <input type="text" name="salesman_phone" id="fn"  value="{{ request('salesman_phone') }}" autocomplete="off" data-placeholder-focus="false" required />
                  <label> تلفن همراه</label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
              <div class="last-name" id="input-last-name">
                  <input type="text" name="description" id="ln" value="{{ request('description') }}" autocomplete="off" data-placeholder-focus="false" required />
                  <label> توضیحات</label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
              <div class="city" id="input-city">
                  <input type="date" name="certificate_date" id="date" value="{{ request('certificate_date') }}" autocomplete="off" data-placeholder-focus="false" />
                  <label> تاریخ اعتبار نمایندگی  </label>
                  <svg class="icon--check" width="21px" height="17px" viewBox="0 0 21 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-255.000000, -746.000000)" fill-rule="nonzero" stroke="#81B44C" stroke-width="3">
                              <polyline id="Path-2" points="257 754.064225 263.505943 760.733489 273.634603 748"></polyline>
                          </g>
                      </g>
                  </svg>
                  <svg class="icon--error" width="15px" height="15px" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                          <g id="UI-Elements-Forms" transform="translate(-550.000000, -747.000000)" fill-rule="nonzero" stroke="#D0021B" stroke-width="3">
                              <g id="Group" transform="translate(552.000000, 749.000000)">
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy"></path>
                                  <path d="M0,11.1298982 L11.1298982,-5.68434189e-14" id="Path-2-Copy-2" transform="translate(5.564949, 5.564949) scale(-1, 1) translate(-5.564949, -5.564949) "></path>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
             
              
              <div class="state" id="select-state">
                  <select name="country_id" id="country-select">
                    <option value="All">All</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}  >{{ $country->name }}</option>
                    @endforeach
                  </select>
                  <label>کشور</label>
                  <svg class="chevron-down" width="17px" height="10px" viewBox="0 0 17 10" version="1.1" xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <g id="UI-Elements-Forms" transform="translate(-840.000000, -753.000000)" stroke="#4A4A4A" stroke-width="0.9">
                              <g id="Done-Copy-2" transform="translate(622.000000, 727.000000)">
                                  <polyline id="Rectangle-16" transform="translate(226.400000, 27.400000) rotate(-45.000000) translate(-226.400000, -27.400000) "
                                      points="231.8 32.8 221 32.8 221 22"></polyline>
                              </g>
                          </g>
                      </g>
                  </svg>
              </div>
          </div>
      </div>
     
  </div>
   <div>
   <table>
            <thead>
            <tr>
            <th>شناسه</th>
            <th>وضعیت</th>
            <th>تاریخ انتشار</th>
            <th>نوع</th>
            <th>نام وسیله</th>
            <th>مدل_وسیله</th>
            <th>برند</th>
            <th>تخصص</th>
            <th>کشور_سازنده </th>
            <th>شرکت_تامین_کننده</th>
            <th>نوع_تامین_کننده</th>
            <th>سابقه_همکاری</th>
            <th>تاریخ_اعتبار_نمایندگی</th>
            <th>قیمت_استعلامی </th>
            <th>تاریخ_استعلام</th>
            <th>قیمت_خرید</th>
            <th>تاریخ_خرید</th>
            <th>نماینده_فروش</th>
            <th>تلفن_همراه</th>
            <th>توضیحات</th>
            </tr>
            </thead>
            <tbody>
                @foreach($results as $data)
                    <tr>
                        <td data-label="Posted">{{ $data['id'] }}</td>
                        <td data-label="Posted">{{ $data['status'] }}</td>
                        <td data-label="Posted">{{ $data['date'] }}</td>
                        <td data-label="Posted">{{ $data['type'] }}</td>
                        <td data-label="Posted">{{ $data['equipment_name'] }}</td>
                        <td data-label="Posted">{{ $data['device_model'] }}</td>
                        <td data-label="Posted">
                            @if($data->brands->isEmpty())
                                N/A
                            @else
                                {{ implode(', ',$data->brands->pluck('name')->toArray()) }}
                            @endif
                        </td>
                        <td data-label="Posted">
                            @if($data->medicalSpecialties->isEmpty())
                                N/A
                            @else
                                {{ implode(', ', $data->medicalSpecialties->pluck('name')->toArray()) }}
                            @endif
                        </td>
                        <td data-label="Posted">
                            @if($data->countries->isEmpty())
                                N/A
                            @else
                                {{ implode(', ', $data->countries->pluck('name')->toArray()) }}
                            @endif
                           
                        </td>
                        <td data-label="Posted">
                            @if($data->supplierCompanies->isEmpty())
                                    N/A
                            @else
                            {{ implode(', ',$data->supplierCompanies->pluck('name')->toArray()) }}
                            @endif

                        </td>
                        <td data-label="Posted">{{ $data['supplier_status_is'] }}</td>
                        <td data-label="Posted">{{ $data['history_working'] }}</td>
                        <td data-label="Posted">{{ $data['certificate_date'] }}</td>
                        <td data-label="Posted">{{ $data['query_price'] }}</td>   
                        <td data-label="Posted">{{ $data['query_date'] }}</td>  
                        <td data-label="Posted">{{ $data['purchase_price'] }}</td>                 
                        <td data-label="Posted">{{ $data['purchase_date'] }}</td>
                        <td data-label="Posted">{{ $data['salesman_agent'] }}</td>
                        <td data-label="Posted">{{ $data['salesman_phone'] }}</td>
                        <td data-label="Posted">{{ $data['description'] }}</td>
                    </tr>
                @endforeach
               
            </tbody>
           
        </table>
            <div class="pagination">
                <ul>
                {{ $results->appends(request()->except('page'))->links() }}
                </ul>
            </div>
   </div>
      
    
  
</form>


<!-- partial -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js'></script><script  src="./script.js"></script>
<script src="{{ asset('home/js/script.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#brand-select').select2({
            placeholder: "جستجو کنید...",
            allowClear: true
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#medical_specialties-select-select').select2({
            placeholder: "جستجو کنید...",
            allowClear: true
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#country-select').select2({
            placeholder: "جستجو کنید...",
            allowClear: true
        });
    });
</script>

<div>



</body>
</html>
