!function(e) {
	"function" == typeof define && define.amd ? define([ "jquery", "moment" ],
			e) : "object" == typeof exports ? module.exports = e(
			require("jquery"), require("moment")) : e(jQuery, moment)
}
		(function(e, t) {
					!function() {
						function e(e) {
							return e % 10 < 5 && e % 10 > 1
									&& ~~(e / 10) % 10 !== 1
						}
						function i(t, i, a) {
							var r = t + " ";
							switch (a) {
							case "m":
								return i ? "minuta" : "minutę";
							case "mm":
								return r + (e(t) ? "minuty" : "minut");
							case "h":
								return i ? "godzina" : "godzinę";
							case "hh":
								return r + (e(t) ? "godziny" : "godzin");
							case "MM":
								return r + (e(t) ? "miesiące" : "miesięcy");
							case "yy":
								return r + (e(t) ? "lata" : "lat")
							}
						}
						var a = "Styczeń_Luty_Marzec_Kwiecień_Maj_Czerwiec_Lipiec_Sierpień_Wrzesień_Październik_Listopad_Grudzień"
								.split("_"), r = "Stycznia_Lutego_Marca_Kwietnia_Maja_Czerwca_Lipca_Sierpnia_Września_Października_Listopada_Grudnia"
								.split("_"), n = t
								.defineLocale(
										"pl",
										{
											months : function(e, t) {
												return "" === t ? "("
														+ r[e.month()] + "|"
														+ a[e.month()] + ")"
														: /D MMMM/.test(t) ? r[e
																.month()]
																: a[e.month()]
											},
											monthsShort : "Sty_Lut_Mar_Kwi_Maj_Cze_Lip_Sie_Wrz_Paź_Lis_Gru"
													.split("_"),
											weekdays : "Niedziela_Poniedziałek_Wtorek_Środa_Czwartek_Piątek_Sobota"
													.split("_"),
											weekdaysShort : "Nie_Pon_Wt_Śr_Czw_Pt_Sb"
													.split("_"),
											weekdaysMin : "Nd_Pn_Wt_Śr_Cz_Pt_So"
													.split("_"),
											longDateFormat : {
												LT : "HH:mm",
												LTS : "HH:mm:ss",
												L : "DD.MM.YYYY",
												LL : "D MMMM YYYY",
												LLL : "D MMMM YYYY HH:mm",
												LLLL : "dddd, D MMMM YYYY HH:mm"
											},
											calendar : {
												sameDay : "[Dziś o] LT",
												nextDay : "[Jutro o] LT",
												nextWeek : "[W] dddd [o] LT",
												lastDay : "[Wczoraj o] LT",
												lastWeek : function() {
													switch (this.day()) {
													case 0:
														return "[W zeszłą niedzielę o] LT";
													case 3:
														return "[W zeszłą środę o] LT";
													case 6:
														return "[W zeszłą sobotę o] LT";
													default:
														return "[W zeszły] dddd [o] LT"
													}
												},
												sameElse : "L"
											},
											relativeTime : {
												future : "za %s",
												past : "%s temu",
												s : "kilka sekund",
												m : i,
												mm : i,
												h : i,
												hh : i,
												d : "1 dzień",
												dd : "%d dni",
												M : "miesiąc",
												MM : i,
												y : "rok",
												yy : i
											},
											ordinalParse : /\d{1,2}\./,
											ordinal : "%d.",
											week : {
												dow : 1,
												doy : 4
											}
										});
						return n
					}(), e.fullCalendar
							.datepickerLocale("pl", "pl",
									{
										closeText : "Zamknij",
										prevText : "&#x3C;Poprzedni",
										nextText : "Następny&#x3E;",
										currentText : "Dziś",
										monthNames : [ "Styczeń", "Luty",
												"Marzec", "Kwiecień", "Maj",
												"Czerwiec", "Lipiec",
												"Sierpień", "Wrzesień",
												"Październik", "Listopad",
												"Grudzień" ],
										monthNamesShort : [ "Sty", "Lu", "Mar",
												"Kw", "Maj", "Cze", "Lip",
												"Sie", "Wrz", "Pa", "Lis",
												"Gru" ],
										dayNames : [ "Niedziela",
												"Poniedziałek", "Wtorek",
												"Środa", "Czwartek", "Piątek",
												"Sobota" ],
										dayNamesShort : [ "Nie", "Pn", "Wt",
												"Śr", "Czw", "Pt", "So" ],
										dayNamesMin : [ "N", "Pn", "Wt", "Śr",
												"Cz", "Pt", "So" ],
										weekHeader : "Tydz",
										dateFormat : "dd.mm.yy",
										firstDay : 1,
										isRTL : !1,
										showMonthAfterYear : !1,
										yearSuffix : ""
									}), e.fullCalendar.locale("pl", {
						buttonText : {
							month : "Miesiąc",
							week : "Tydzień",
							day : "Dzień",
							list : "Plan dnia"
						},
						allDayText : "Cały dzień",
						eventLimitText : "więcej",
						noEventsMessage : "Brak wydarzeń do wyświetlenia"
					})
		});