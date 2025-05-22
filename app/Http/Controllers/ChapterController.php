<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $chapterList = Chapter::get();
            return DataTables::of($chapterList)
            ->addColumn('action', function($chapterList) use($request){
                $actionHTML = (checkPermission([app('router')->getRoutes()->getByName('chapter.edit.form')->uri])) ? '<a href="'.route('chapter.edit.form', [encode_url($chapterList['id'])]).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                            </g>
                        </svg>
                    </span>
                </a>' : '';
                $actionHTML .= (checkPermission([app('router')->getRoutes()->getByName('chapter.destroy')->uri])) ? '
                    <button data-deleteURL="'.route('chapter.destroy', [encode_url($chapterList['id'])]).'" class="btn btn-sm btn-clean btn-icon" title="Delete" data-alertMessage="Chapter deleted won\'t be reveret back!" data-dataTableReloadid="#chapter_datatable" onclick="showcommonDeleteAlert(this)">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                </g>
                            </svg>
                        </span>
                    </button>' : '';
                return $actionHTML;
            })
            ->addIndexColumn()
            ->rawColumns([])
            ->make(true);
        }

        $page_title = 'Chapters';
        $page_description = 'This is custom page.';
        return view('chapter.list', ['page_title' => $page_title, 'page_description' => $page_description]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Chapter Creation';
        $page_description = 'This is custom page.';

        return view('chapter.create', ['page_title' => $page_title, 'page_description' => $page_description]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'chapter_name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingChapter = Chapter::where('chapter_name', strtolower($value))->first();
                    if( !$existingChapter ){
                        return true;
                    }else{
                        $fail('Chapter Already existing');
                    }
                }
            ]
        ],[],[
            "chapter_name.required" => "Chapter Name",
        ]);

        $insertChapter = new Chapter();
        $insertChapter->chapter_name = $request['chapter_name'];
        $insertChapter->save();
        return redirect()->route('chapter.index')->with('success', 'Chapter added successfully!' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function show(chapter $chapter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $chapterId)
    {
        $page_title = 'Chapter Edit';
        $page_description = 'This is custom page.';
        $editChapter = Chapter::find(decode_url($chapterId));
        return view('chapter.edit',['page_title' => $page_title, 'page_description' => $page_description, 'editChapter' => $editChapter]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $chapterId)
    {
        $request->validate([
            'chapter_name' => [
                'required',
                function ($attribute, $value, $fail) use ($chapterId) {
                    $existingChapter = Chapter::where('id', '!=',decode_url($chapterId))->where('chapter_name', strtolower($value))->first();
                    if( !$existingChapter ){
                        return true;
                    }else{
                        $fail('Chapter Already existing');
                    }
                }
            ]
        ],[],[
            "chapter_name.required" => "Chapter Name",
        ]);

        $insertChapter = Chapter::find(decode_url($chapterId));
        $insertChapter->chapter_name = $request['chapter_name'];
        $insertChapter->save();
        return redirect()->route('chapter.index')->with('success', 'Chapter updated successfully!' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $chapterId)
    {
        $deleteChapter = Chapter::find(decode_url($chapterId));
        $deleteChapter->delete();
        return response()->json(['message' => 'Chapter has been deleted.','status'=>1]);
    }
}
