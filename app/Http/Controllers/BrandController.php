<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Services\Interfaces\BrandInterface;

class BrandController extends Controller
{
    public function __construct(private BrandInterface $brandRepository) {}

    public function index()
    {
        $brands = $this->brandRepository->getAllBrands();

        return view('pages.brand.index', compact('brands'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

        return view('pages.brand.create');
    }

    public function store(StoreBrandRequest $request)
    {
        $this->brandRepository->createBrand($request->validated());

        return redirect()->route('brands.index')->withSuccess('Berhasil ditambahkan');
    }

    public function edit(Brand $brand)
    {
        if (!Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

        return view('pages.brand.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());

        return redirect()->route('brands.index')->withSuccess('Berhasil diubah');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')->withSuccess('Berhasil dihapus');;
    }
}
