@extends('index')
@section('container')
<div class="sec_dashboard">
    <div class="part_sec_dash">
        <h2>Analytics</h2>
        <div class="dash_sst gd-2">
            <img src="{{ asset('/assets/img/utama/logokunci.png') }}" alt="sample page">
            <div class="list_data_l21">
                <div class="sec_card_count">
                    <div class="prog_icon_circle primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-world-www" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M19.5 7a9 9 0 0 0 -7.5 -4a8.991 8.991 0 0 0 -7.484 4"></path>
                            <path d="M11.5 3a16.989 16.989 0 0 0 -1.826 4"></path>
                            <path d="M12.5 3a16.989 16.989 0 0 1 1.828 4"></path>
                            <path d="M19.5 17a9 9 0 0 1 -7.5 4a8.991 8.991 0 0 1 -7.484 -4"></path>
                            <path d="M11.5 21a16.989 16.989 0 0 1 -1.826 -4"></path>
                            <path d="M12.5 21a16.989 16.989 0 0 0 1.828 -4"></path>
                            <path d="M2 10l1 4l1.5 -4l1.5 4l1 -4"></path>
                            <path d="M17 10l1 4l1.5 -4l1.5 4l1 -4"></path>
                            <path d="M9.5 10l1 4l1.5 -4l1.5 4l1 -4"></path>
                        </svg>
                        <div class="half_circle"></div>
                    </div>
                    <div class="detail_count">
                        <h3>{{ 0 }}</h3>
                        <span>Total Visitor</span>
                    </div>
                </div>
                <div class="sec_card_count">
                    <div class="prog_icon_circle warning">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tags" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M7.859 6h-2.834a2.025 2.025 0 0 0 -2.025 2.025v2.834c0 .537 .213 1.052 .593 1.432l6.116 6.116a2.025 2.025 0 0 0 2.864 0l2.834 -2.834a2.025 2.025 0 0 0 0 -2.864l-6.117 -6.116a2.025 2.025 0 0 0 -1.431 -.593z"></path>
                            <path d="M17.573 18.407l2.834 -2.834a2.025 2.025 0 0 0 0 -2.864l-7.117 -7.116"></path>
                            <path d="M6 9h-.01"></path>
                        </svg>
                        <div class="half_circle"></div>
                    </div>
                    <div class="detail_count">
                        <h3>{{ 0 }}</h3>
                        <span>Total Template</span>
                    </div>
                </div>
                <div class="sec_card_count">
                    <div class="prog_icon_circle success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
                            <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                            <path d="M15 3v4"></path>
                            <path d="M7 3v4"></path>
                            <path d="M3 11h16"></path>
                            <path d="M18 16.496v1.504l1 1"></path>
                        </svg>
                        <div class="half_circle"></div>
                    </div>
                    <div class="detail_count">
                        <h3>{{ 0 }}</h3>
                        <span>Total Data URL</span>
                    </div>
                </div>
                <div class="sec_card_count">
                    <div class="prog_icon_circle primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-google-analytics" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M10 9m0 1.105a1.105 1.105 0 0 1 1.105 -1.105h1.79a1.105 1.105 0 0 1 1.105 1.105v9.79a1.105 1.105 0 0 1 -1.105 1.105h-1.79a1.105 1.105 0 0 1 -1.105 -1.105z" />
                            <path d="M17 3m0 1.105a1.105 1.105 0 0 1 1.105 -1.105h1.79a1.105 1.105 0 0 1 1.105 1.105v15.79a1.105 1.105 0 0 1 -1.105 1.105h-1.79a1.105 1.105 0 0 1 -1.105 -1.105z" />
                            <path d="M5 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        </svg>
                        <div class="half_circle"></div>
                    </div>
                    <div class="detail_count">
                        <h3>{{ 0 }}</h3>
                        <span>Total Keyword</span>
                    </div>
                </div>
                <div class="sec_card_count">
                    <div class="prog_icon_circle secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gift" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 8m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z"></path>
                            <path d="M12 8l0 13"></path>
                            <path d="M19 12v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-7"></path>
                            <path d="M7.5 8a2.5 2.5 0 0 1 0 -5a4.8 8 0 0 1 4.5 5a4.8 8 0 0 1 4.5 -5a2.5 2.5 0 0 1 0 5"></path>
                        </svg>
                        <div class="half_circle"></div>
                    </div>
                    <div class="detail_count">
                        <h3>**</h3>
                        <span>Lorem Ipsum</span>
                    </div>
                </div>
                <div class="sec_card_count">
                    <div class="prog_icon_circle danger">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo-search" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M15 8h.01"></path>
                            <path d="M11.5 21h-5.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v5.5"></path>
                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                            <path d="M20.2 20.2l1.8 1.8"></path>
                            <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l2 2"></path>
                        </svg>
                        <div class="half_circle"></div>
                    </div>
                    <div class="detail_count">
                        <h3>**</h3>
                        <span>Lorem Ipsum</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="group_view_code">
    <div class="sec_box">
        <div class="bar_code">
            <div class="preview_code">
                <div class="sec_table">
                    <h2>Keyword Rank</h2>
                    <table>
                        <tbody>
                            <tr class="head_table">
                                <th class="check_box">
                                    <input type="checkbox" id="myCheckbox" name="myCheckbox" value="1">
                                </th>
                                <th>keyword</th>
                                <th>count</th>
                            </tr>
                            @foreach($keywords as $keyword)
                            <tr>
                                <td class="check_box">
                                    <input type="checkbox" id="myCheckbox" name="myCheckbox" value="1">
                                </td>
                                    <td><span class="keyword">{{ $keyword->key }}</span></td>
                                    <td><span class="count">{{ $keyword->count }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="copy_code">
            <div class="sec_table">
                    <h2>Template List</h2>         
                    <table>
                        <tbody>
                            <tr class="head_table">
                                <th class="check_box">
                                    <input type="checkbox" id="myCheckbox" name="myCheckbox" value="1">
                                </th>
                                <th>Template</th>
                                <th>count</th>
                            </tr>
                            @foreach ($topSitus as $template)
                            <tr>
                                <td class="check_box">
                                    <input type="checkbox" id="myCheckbox" name="myCheckbox" value="1">
                                </td>
                                <td><span class="name">{{ $template->name }}</span></td>
                                <td><span class="count">{{ $template->count }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="group_view_code">
    <div class="sec_box">
        <div class="bar_code">
            <div class="preview_code">
                <div class="sec_table">
                    <h2>Most Viewed Template</h2>
                    <table>
                        <tbody>
                            <tr class="head_table">
                                <th class="check_box">
                                    <input type="checkbox" id="myCheckbox" name="myCheckbox" value="1">
                                </th>
                                <th>Template</th>
                                <th>count</th>
                            </tr>
                            @foreach ($toprankSitus as $toprank)
                            <tr>
                                <td class="check_box">
                                    <input type="checkbox" id="myCheckbox" name="myCheckbox" value="1">
                                </td>
                                <td><span class="name">{{ $toprank->name }}</span></td>
                                <td><span class="count">{{ $toprank->count }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="copy_code">
            <div class="sec_table">
                    <h2>Most Non-Viewed Template</h2>
                    <table>
                        <tbody>
                            <tr class="head_table">
                                <th class="check_box">
                                    <input type="checkbox" id="myCheckbox" name="myCheckbox" value="1">
                                </th>
                                <th>Template</th>
                            </tr>
                            @foreach ($norankSitus as $norank)
                            <tr>
                                <td class="check_box">
                                    <input type="checkbox" id="myCheckbox" name="myCheckbox" value="1">
                                </td>
                                <td><span class="name">{{ $norank->name }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    
</div>
@endsection