
(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:MediaProcessing" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="MediaProcessing.html">MediaProcessing</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:MediaProcessing_ImageFilter" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="MediaProcessing/ImageFilter.html">ImageFilter</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:MediaProcessing_ImageFilter_Filter" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="MediaProcessing/ImageFilter/Filter.html">Filter</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:MediaProcessing_ImageFilter_Filter_Resize" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MediaProcessing/ImageFilter/Filter/Resize.html">Resize</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:MediaProcessing_ImageFilter_ImageFilter" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="MediaProcessing/ImageFilter/ImageFilter.html">ImageFilter</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:MediaProcessing_AbstractFilter" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MediaProcessing/AbstractFilter.html">AbstractFilter</a>                    </div>                </li>                            <li data-name="class:MediaProcessing_FilterInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MediaProcessing/FilterInterface.html">FilterInterface</a>                    </div>                </li>                            <li data-name="class:MediaProcessing_MediaFile" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MediaProcessing/MediaFile.html">MediaFile</a>                    </div>                </li>                            <li data-name="class:MediaProcessing_MediaProcessor" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MediaProcessing/MediaProcessor.html">MediaProcessor</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "MediaProcessing.html", "name": "MediaProcessing", "doc": "Namespace MediaProcessing"},{"type": "Namespace", "link": "MediaProcessing/ImageFilter.html", "name": "MediaProcessing\\ImageFilter", "doc": "Namespace MediaProcessing\\ImageFilter"},{"type": "Namespace", "link": "MediaProcessing/ImageFilter/Filter.html", "name": "MediaProcessing\\ImageFilter\\Filter", "doc": "Namespace MediaProcessing\\ImageFilter\\Filter"},
            {"type": "Interface", "fromName": "MediaProcessing", "fromLink": "MediaProcessing.html", "link": "MediaProcessing/FilterInterface.html", "name": "MediaProcessing\\FilterInterface", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MediaProcessing\\FilterInterface", "fromLink": "MediaProcessing/FilterInterface.html", "link": "MediaProcessing/FilterInterface.html#method_getTargetFilename", "name": "MediaProcessing\\FilterInterface::getTargetFilename", "doc": "&quot;Build the target filename&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\FilterInterface", "fromLink": "MediaProcessing/FilterInterface.html", "link": "MediaProcessing/FilterInterface.html#method_process", "name": "MediaProcessing\\FilterInterface::process", "doc": "&quot;The filter processing method, must return an file resource&quot;"},
            
            
            {"type": "Class", "fromName": "MediaProcessing", "fromLink": "MediaProcessing.html", "link": "MediaProcessing/AbstractFilter.html", "name": "MediaProcessing\\AbstractFilter", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MediaProcessing\\AbstractFilter", "fromLink": "MediaProcessing/AbstractFilter.html", "link": "MediaProcessing/AbstractFilter.html#method___construct", "name": "MediaProcessing\\AbstractFilter::__construct", "doc": "&quot;Construction of a filter&quot;"},
            
            {"type": "Class", "fromName": "MediaProcessing", "fromLink": "MediaProcessing.html", "link": "MediaProcessing/FilterInterface.html", "name": "MediaProcessing\\FilterInterface", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MediaProcessing\\FilterInterface", "fromLink": "MediaProcessing/FilterInterface.html", "link": "MediaProcessing/FilterInterface.html#method_getTargetFilename", "name": "MediaProcessing\\FilterInterface::getTargetFilename", "doc": "&quot;Build the target filename&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\FilterInterface", "fromLink": "MediaProcessing/FilterInterface.html", "link": "MediaProcessing/FilterInterface.html#method_process", "name": "MediaProcessing\\FilterInterface::process", "doc": "&quot;The filter processing method, must return an file resource&quot;"},
            
            {"type": "Class", "fromName": "MediaProcessing\\ImageFilter\\Filter", "fromLink": "MediaProcessing/ImageFilter/Filter.html", "link": "MediaProcessing/ImageFilter/Filter/Resize.html", "name": "MediaProcessing\\ImageFilter\\Filter\\Resize", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\Filter\\Resize", "fromLink": "MediaProcessing/ImageFilter/Filter/Resize.html", "link": "MediaProcessing/ImageFilter/Filter/Resize.html#method_getTargetFilename", "name": "MediaProcessing\\ImageFilter\\Filter\\Resize::getTargetFilename", "doc": "&quot;Build the target filename&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\Filter\\Resize", "fromLink": "MediaProcessing/ImageFilter/Filter/Resize.html", "link": "MediaProcessing/ImageFilter/Filter/Resize.html#method_calculateSourceHandlerSizes", "name": "MediaProcessing\\ImageFilter\\Filter\\Resize::calculateSourceHandlerSizes", "doc": "&quot;Calculate the source image width &amp;amp; height from the resource&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\Filter\\Resize", "fromLink": "MediaProcessing/ImageFilter/Filter/Resize.html", "link": "MediaProcessing/ImageFilter/Filter/Resize.html#method_calculateTargetSizes", "name": "MediaProcessing\\ImageFilter\\Filter\\Resize::calculateTargetSizes", "doc": "&quot;Calculate the target image width &amp;amp; height from the source sizes and set options&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\Filter\\Resize", "fromLink": "MediaProcessing/ImageFilter/Filter/Resize.html", "link": "MediaProcessing/ImageFilter/Filter/Resize.html#method_process", "name": "MediaProcessing\\ImageFilter\\Filter\\Resize::process", "doc": "&quot;The filter processing method, must return an image resource&quot;"},
            
            {"type": "Class", "fromName": "MediaProcessing\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html", "name": "MediaProcessing\\ImageFilter\\ImageFilter", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method___construct", "name": "MediaProcessing\\ImageFilter\\ImageFilter::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_setSourceFile", "name": "MediaProcessing\\ImageFilter\\ImageFilter::setSourceFile", "doc": "&quot;Creates and stores a \&quot;\\MediaProcessing\\MediaFile\&quot; object of the source file&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_getSourceFile", "name": "MediaProcessing\\ImageFilter\\ImageFilter::getSourceFile", "doc": "&quot;Get the source object&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_setTargetFilename", "name": "MediaProcessing\\ImageFilter\\ImageFilter::setTargetFilename", "doc": "&quot;Set the target filename&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_getTargetFilename", "name": "MediaProcessing\\ImageFilter\\ImageFilter::getTargetFilename", "doc": "&quot;Get the target file name&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_getTargetWebPath", "name": "MediaProcessing\\ImageFilter\\ImageFilter::getTargetWebPath", "doc": "&quot;Get the target file path (web accessible)&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_addFilter", "name": "MediaProcessing\\ImageFilter\\ImageFilter::addFilter", "doc": "&quot;Add a filter in the filter stack&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_setFilters", "name": "MediaProcessing\\ImageFilter\\ImageFilter::setFilters", "doc": "&quot;Add a filter in the filter stack&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_reset", "name": "MediaProcessing\\ImageFilter\\ImageFilter::reset", "doc": "&quot;Reset the source file object&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_resetFilters", "name": "MediaProcessing\\ImageFilter\\ImageFilter::resetFilters", "doc": "&quot;Reset the filters stack and associated options&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_getCache", "name": "MediaProcessing\\ImageFilter\\ImageFilter::getCache", "doc": "&quot;Get the cached file path if found&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_process", "name": "MediaProcessing\\ImageFilter\\ImageFilter::process", "doc": "&quot;Process the filters stack on the source&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_buildSourceFileHandler", "name": "MediaProcessing\\ImageFilter\\ImageFilter::buildSourceFileHandler", "doc": "&quot;Build a resource to handle source file with the same MIME type as source&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_writeTargetFileHandler", "name": "MediaProcessing\\ImageFilter\\ImageFilter::writeTargetFileHandler", "doc": "&quot;Write the target handler in a real file&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_buildSourceFileFromContent", "name": "MediaProcessing\\ImageFilter\\ImageFilter::buildSourceFileFromContent", "doc": "&quot;Create a file with the image content to work on and returns the created filename&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\ImageFilter\\ImageFilter", "fromLink": "MediaProcessing/ImageFilter/ImageFilter.html", "link": "MediaProcessing/ImageFilter/ImageFilter.html#method_resizeWidthHeight", "name": "MediaProcessing\\ImageFilter\\ImageFilter::resizeWidthHeight", "doc": "&quot;Recalculate width &amp;amp; height conserving the original ratio&quot;"},
            
            {"type": "Class", "fromName": "MediaProcessing", "fromLink": "MediaProcessing.html", "link": "MediaProcessing/MediaFile.html", "name": "MediaProcessing\\MediaFile", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MediaProcessing\\MediaFile", "fromLink": "MediaProcessing/MediaFile.html", "link": "MediaProcessing/MediaFile.html#method___construct", "name": "MediaProcessing\\MediaFile::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\MediaFile", "fromLink": "MediaProcessing/MediaFile.html", "link": "MediaProcessing/MediaFile.html#method_setClientFilename", "name": "MediaProcessing\\MediaFile::setClientFilename", "doc": "&quot;Set the client filename&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\MediaFile", "fromLink": "MediaProcessing/MediaFile.html", "link": "MediaProcessing/MediaFile.html#method_getClientFilename", "name": "MediaProcessing\\MediaFile::getClientFilename", "doc": "&quot;Get the client filename if so, the filename if not&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\MediaFile", "fromLink": "MediaProcessing/MediaFile.html", "link": "MediaProcessing/MediaFile.html#method_getFilenameWithoutExtension", "name": "MediaProcessing\\MediaFile::getFilenameWithoutExtension", "doc": "&quot;Get the filename without extension&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\MediaFile", "fromLink": "MediaProcessing/MediaFile.html", "link": "MediaProcessing/MediaFile.html#method_guessExtension", "name": "MediaProcessing\\MediaFile::guessExtension", "doc": "&quot;Get the file extension or guess it from MIME type if so .&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\MediaFile", "fromLink": "MediaProcessing/MediaFile.html", "link": "MediaProcessing/MediaFile.html#method_getMime", "name": "MediaProcessing\\MediaFile::getMime", "doc": "&quot;Get the file mime string if possible&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\MediaFile", "fromLink": "MediaProcessing/MediaFile.html", "link": "MediaProcessing/MediaFile.html#method_getHumanSize", "name": "MediaProcessing\\MediaFile::getHumanSize", "doc": "&quot;Get the file size in human readable string&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\MediaFile", "fromLink": "MediaProcessing/MediaFile.html", "link": "MediaProcessing/MediaFile.html#method_getATimeAsDatetime", "name": "MediaProcessing\\MediaFile::getATimeAsDatetime", "doc": "&quot;Get the last access time on the file and return it as a DateTime object&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\MediaFile", "fromLink": "MediaProcessing/MediaFile.html", "link": "MediaProcessing/MediaFile.html#method_getCTimeAsDatetime", "name": "MediaProcessing\\MediaFile::getCTimeAsDatetime", "doc": "&quot;Get the creation time on the file and return it as a DateTime object&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\MediaFile", "fromLink": "MediaProcessing/MediaFile.html", "link": "MediaProcessing/MediaFile.html#method_getMTimeAsDatetime", "name": "MediaProcessing\\MediaFile::getMTimeAsDatetime", "doc": "&quot;Get the last modification time on the file and return it as a DateTime object&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\MediaFile", "fromLink": "MediaProcessing/MediaFile.html", "link": "MediaProcessing/MediaFile.html#method_isImage", "name": "MediaProcessing\\MediaFile::isImage", "doc": "&quot;Check if a file seems to be an image, based on its mime type signature&quot;"},
            
            {"type": "Class", "fromName": "MediaProcessing", "fromLink": "MediaProcessing.html", "link": "MediaProcessing/MediaProcessor.html", "name": "MediaProcessing\\MediaProcessor", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MediaProcessing\\MediaProcessor", "fromLink": "MediaProcessing/MediaProcessor.html", "link": "MediaProcessing/MediaProcessor.html#method_setTemporaryDirectory", "name": "MediaProcessing\\MediaProcessor::setTemporaryDirectory", "doc": "&quot;Sets the temporary directory&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\MediaProcessor", "fromLink": "MediaProcessing/MediaProcessor.html", "link": "MediaProcessing/MediaProcessor.html#method_getTemporaryDirectory", "name": "MediaProcessing\\MediaProcessor::getTemporaryDirectory", "doc": "&quot;Gets the temporary directory&quot;"},
                    {"type": "Method", "fromName": "MediaProcessing\\MediaProcessor", "fromLink": "MediaProcessing/MediaProcessor.html", "link": "MediaProcessing/MediaProcessor.html#method_createFromContent", "name": "MediaProcessing\\MediaProcessor::createFromContent", "doc": "&quot;Create a file with a content string and returns the created filename&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


