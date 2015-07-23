/**
 * @category    MT
 * @package     MT_Widget
 * @copyright   Copyright (C) 2008-2013 MagentoThemes.net. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      MagentoThemes.net
 * @email       support@magentothemes.net
 */
function getFlexSliderItemWidth(id, data, returnType){
    if (data && data.type){
        var containerW = Math.floor(jQuery('#' + id).width());
        switch (data.type){
            case 'width':
                if (returnType === 'width') return data.data;
                else if (returnType === 'column'){
                    return Math.floor(containerW / (data.data + data.margin * 2)) || 1;
                }
                break;
            case 'breakpoint':
                var breakpoints = data.data.split(' '),
                    BKP = [],
                    column = null;
                breakpoints.each(function(breakpoint){
                    if (breakpoint){
                        var config = breakpoint.split(':');
                        if (config.length === 2 && !isNaN(config[0]) && !isNaN(config[1])){
                            var obj = {
                                width: config[0],
                                column: config[1]
                            };
                            BKP.push(obj);
                        }
                    }
                });
                BKP.sort(function(a, b){ return a.width - b.width});
                BKP.each(function(bkp){
                    if (!column && bkp.width > containerW){
                        column = bkp.column;
                    }
                });
                column = column ? column : BKP.pop().column;
                if (returnType === 'width'){
                    return Math.floor(containerW / column) || 1;
                }else if (returnType === 'column'){
                    return column;
                }
                break;
        }
    }
}

function getVideoId(url){
    var videoId, videoType;
    if (url.indexOf('youtube.com') > 0){
        videoType = 'youtube';
        videoId = url.split('v=')[1];
        videoId = videoId ? (videoId.indexOf('&') > 0 ? videoId.substring(0, videoId.indexOf('&')) : videoId) : videoId;
    }else if (url.indexOf('vimeo.com') > 0){
        videoType = 'vimeo';
        videoId = url.replace(/[^0-9]+/g, '');
    }
    return [videoType, videoId ? videoId.strip() : ''];
}

function addJsAPI(service){
    var tag = document.createElement('script');
    switch (service){
        case 'youtube':
            tag.src = "//www.youtube.com/iframe_api";
            break;
        case 'vimeo':
            //tag.src = '//a.vimeocdn.com/js/froogaloop2.min.js';
            break;
    }
    if (tag.src){
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }
}

function calParallaxVideoSize(div){
    var parent = $(div),
        dimensions = parent.getDimensions(),
        height = parseInt(dimensions.width * 0.5625),
        top = height > dimensions.height ? parseInt((height - dimensions.height)/2) : 0;
    return {height:height, top:top};
}

function onYouTubeIframeAPIReady(){
    var d = calParallaxVideoSize($(window.parallax.Youtube.Div).up());
    window.parallax.Youtube.Player = new YT.Player(window.parallax.Youtube.Div, {
        height: d.height,
        width: '100%',
        playerVars: {
            autoplay: 1,
            autohide: 1,
            controls: 0,
            loop: 1,
            showinfo: 1,
            wmode: 'transparent',
            html5: 1,
            rel: 0,
            playlist: window.parallax.Youtube.Video
        },
        videoId: window.parallax.Youtube.Video,
        events: {
            'onReady': onYoutubePlayerReady
        }
    });
}

function onYoutubePlayerReady(ev){
    var id = ev.target.a.id,
        d = calParallaxVideoSize($(id).up());

    $(ev.target.a).setStyle({
        top: -1*d.top + 'px'
    });
    if (!window.parallax.Youtube.Volume) ev.target.mute();
    ev.target.playVideo();
    $(window.parallax.Youtube.Overlay).update('');
}

function addVideoMuteButton(div, flag){
    div = $(div);
    if (!div) return;
    var btn = new Element('i', {'class':'videoMuteBtn fa', href:'javascript:void(0)'});
    if (flag) btn.addClassName('fa-volume-up');
    else btn.addClassName('fa-volume-off');
    div.insert({bottom:btn});
    return btn;
}

function post_message(player, method, value){
    var data = {method: method};
    if (value != null) data.value = value;
    player.contentWindow.postMessage(JSON.stringify(data), player.src.split('?')[0]);
}

function insertVideoBackground(div, video){
    var videoData = getVideoId(video.video);

    if (videoData[0]){
        switch (videoData[0]){
            case 'youtube':
                addJsAPI('youtube');
                window.parallax = {};
                window.parallax.Youtube = {};
                window.parallax.Youtube.Video = videoData[1];
                window.parallax.Youtube.Div = div + '-video';
                window.parallax.Youtube.Overlay = div + '-overlay';
                window.parallax.Youtube.Volume = video.volume;
                var muteBtn = addVideoMuteButton(div, video.volume);
                Event.observe(muteBtn, 'click', function(){
                    var player = window.parallax.Youtube.Player;
                    if (!player) return;
                    if (player.isMuted()){
                        player.unMute();
                        this.removeClassName('fa-volume-off');
                        this.addClassName('fa-volume-up');
                    }else{
                        this.addClassName('fa-volume-off');
                        this.removeClassName('fa-volume-up');
                        player.mute();
                    }
                });
                break;
            case 'vimeo':
                addJsAPI('vimeo');
                window.parallax = {};
                window.parallax.Vimeo = {};
                var videoSrc = '//player.vimeo.com/video/'+videoData[1]+'?title=0&byline=0&portrait=0&autoplay=1&loop=1&api=1';
                var parent = $(div),
                    muteBtn = addVideoMuteButton(div, video.volume),
                    d= calParallaxVideoSize(div),
                    iframe = new Element('iframe', {
                        src: videoSrc,
                        frameborder: 0,
                        allowfullscreen: 1,
                        id: div + '-video',
                        height: d.height,
                        width: '100%'
                    }).setStyle({top: -1* d.top + 'px'});
                parent.down('#'+div+'-video').replace(iframe);
                window.parallax.Vimeo.Player = iframe;
                Event.observe(muteBtn, 'click', function(){
                    if (!window.parallax.Vimeo.Player) return;
                    if (window.parallax.Vimeo.Player.muted == 0){
                        var value = 0;
                        window.parallax.Vimeo.Player.muted = 1;
                        this.removeClassName('fa-volume-up');
                        this.addClassName('fa-volume-off');
                    }else{
                        var value = 1;
                        window.parallax.Vimeo.Player.muted = 0;
                        this.addClassName('fa-volume-up');
                        this.removeClassName('fa-volume-off');
                    }
                    post_message(window.parallax.Vimeo.Player, 'setVolume', value);
                });
                Event.observe(window, 'message', function(e){
                    var data = JSON.parse(e.data);
                    switch (data.event){
                        case 'ready':
                            if (!window.parallax.Vimeo.Player) return;
                            post_message(window.parallax.Vimeo.Player, 'addEventListener', 'play');
                            break;
                        case 'play':
                            if (!window.parallax.Vimeo.Player) return;
                            $(div + '-overlay').update('');
                            if (!video.volume){
                                post_message(window.parallax.Vimeo.Player, 'setVolume', 0);
                                window.parallax.Vimeo.Player.muted = 1;
                            }else window.parallax.Vimeo.Player.muted = 0;
                            break;
                    }
                });
                break;
        }

        Event.observe(window, 'resize', function(){
            var parent = $(div),
                d = calParallaxVideoSize(parent),
                iframe = parent.down('iframe');
            if (iframe) iframe.setStyle({height: d.height + 'px', top: -1 * d.top + 'px'});
        });
    }
}