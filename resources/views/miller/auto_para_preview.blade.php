<fieldset id="auto_para_preview" style="display:block;">
    <div class="card">

		<div class="card-header flex justify-between">
			<span class="text-xl"> <b>যন্ত্রপাতির বিবরণ </b></span>
			@if($edit_perm)
			<span> <div align="right" class="print_hide"><button id="auto_para" class="btn2 btn-primary edit-button">এডিট</button>  </div>
			</span>
			@endif
		</div>

		<div class="card-body">

            <table width="100%" align="center" id="param_table">

                    <tbody><tr>

						<td width="5%">ক্রঃ নং</td>

						<td align="center">প্যারামিটার এর নাম</td>

						<td align="center">সংখ্যা</td>

						<td align="center">একক ক্ষমতা</td>

						<td align="center">মোট ক্ষমতা</td>

						</tr>

						<tr>

						<td width="5%">০১.</td>

						<td> {{$miller->autometic_miller->parameter1_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter1_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter1_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter1_topower}}</td>

						</tr>


						<tr>

						<td width="5%">০২.</td>

						<td> {{$miller->autometic_miller->parameter2_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter2_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter2_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter2_topower}}</td>

						 </tr>



						<tr>

						<td width="5%">০৩.</td>

						<td> {{$miller->autometic_miller->parameter3_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter3_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter3_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter3_topower}}</td>

						 </tr>



						<tr>

						<td width="5%">০৪.</td>

						<td> {{$miller->autometic_miller->parameter4_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter4_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter4_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter4_topower}}</td>

						</tr>



						<tr>

						<td width="5%">০৫.</td>

						<td> {{$miller->autometic_miller->parameter5_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter5_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter5_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter5_topower}}</td>

						</tr>



						<tr>

						<td width="5%">০৬.</td>

						<td> {{$miller->autometic_miller->parameter6_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter6_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter6_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter6_topower}}</td>

						</tr>



						<tr>

                            <td width="5%">০৭.</td>

                            <td> {{$miller->autometic_miller->parameter7_name}}</td>

                            <td align="center">{{$miller->autometic_miller->parameter7_num}}</td>

                            <td align="center">{{$miller->autometic_miller->parameter7_power}}</td>

                            <td align="center">{{$miller->autometic_miller->parameter7_topower}}</td>

						</tr>



						<tr>

						<td width="5%">০৮.</td>

						<td> {{$miller->autometic_miller->parameter8_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter8_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter8_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter8_topower}}</td>

						</tr>



						<tr>

						<td width="5%">০৯.</td>

						<td> {{$miller->autometic_miller->parameter9_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter9_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter9_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter9_topower}}</td>

						</tr>



						<tr>

						<td width="5%">১০.</td>

						<td> {{$miller->autometic_miller->parameter10_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter10_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter10_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter10_topower}}</td>

						</tr>





						<tr>

						<td width="5%">১১.</td>

						<td> {{$miller->autometic_miller->parameter11_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter11_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter11_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter11_topower}}</td>

						</tr>



						<tr>

						<td width="5%">১২.</td>

						<td> {{$miller->autometic_miller->parameter12_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter12_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter12_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter12_topower}}</td>

						</tr>



						<tr>

						<td width="5%">১৩.</td>

						<td> {{$miller->autometic_miller->parameter13_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter13_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter13_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter13_topower}}</td>

						</tr>



						<tr>

						<td width="5%">১৪.</td>

						<td> {{$miller->autometic_miller->parameter14_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter14_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter14_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter14_topower}}</td>

						</tr>



						<tr>

						<td width="5%">১৫.</td>

						<td> {{$miller->autometic_miller->parameter15_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter15_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter15_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter15_topower}}</td>

						</tr>



						<tr>

						<td width="5%">১৬.</td>

						<td> {{$miller->autometic_miller->parameter16_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter16_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter16_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter16_topower}}</td>

						</tr>



						<tr>

						<td width="5%">১৭.</td>

						<td> {{$miller->autometic_miller->parameter17_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter17_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter17_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter17_topower}}</td>

						</tr>



						<tr>

						<td width="5%">১৮.</td>

						<td> {{$miller->autometic_miller->parameter18_name}}</td>

						<td align="center">{{$miller->autometic_miller->parameter18_num}}</td>

						<td align="center">{{$miller->autometic_miller->parameter18_power}}</td>

						<td align="center">{{$miller->autometic_miller->parameter18_topower}}</td>

						 </tr>

						<tr>

						<td width="5%">১৯.</td>

						<td> {{$miller->autometic_miller->parameter19_name}}</td>

						<td colspan="3" align="center">{{$miller->autometic_miller->parameter19_topower}}</td>

						 </tr>



                        </tbody></table>

                </div>
    </div>
    </fieldset>
