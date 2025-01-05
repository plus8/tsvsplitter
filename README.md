# tsvsplitter
Rapidly segment large spreadsheets via search - really handy for doing your taxes/end-of-year-accounts and segmenting stuff like paypal history

copy and paste to and from your spreadsheet of choice. Additive search, select fields manually or by search, and it splits the outputs into separate datasets  that you can paste back into your spreadsheet.


The reason for this tool is because whilst you can select multiple rows in [spreadsheet programs], they cannot include gaps. So whilst you could quickly go through and tag relevant rows, there's no way of copying them out as a single chunk. TSVsplitter does just that, and more.


The search is additive so you can build up a result-set based on multiple searches - e.g. misspellings, alternative capitalisations etc. so e.g search first on "HAMSTERS", returns some  results, then "Hamsters" adds those results to the set, then "hamsters" adds those results too. 

This accounts for how companies often slightly change their display name on the statement. 

Then at the bottom it splits into the original results without the selected elements, and a set with the searched results

You can then "recycle" the first dataset (minus the searched fields you just removed) back into the inputs and start again, so can rapidly find all the transactions of a particular type, and segment them out to give you totals. 

If you've ever had to wade through 3k+ lines of paypal history you will likely enjoy this tool 😎


This was originally written in asp classic which shows how long I've been using it ;-) (rewrote it in php a few years back)


