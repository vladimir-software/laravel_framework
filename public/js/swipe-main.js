/**
 * main.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2015, Codrops
 * http://www.codrops.com
 */
$(document).ready(function () {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data: {limit: $('#stack_iman li').length},
        url: "adView",
        dataType: 'json',
        context: this,
        success: function (data) {
        
            if (data.status == 'success') {
                var rec = [];
                var i = 1;
                var len = $('#stack_iman li').length;
                var before = '<li class="stack__item userConnectionDataContainer test">';
                var after = '</li>';
                $.each(data.data, function (index, value) {
                    if (value.url == '' || value.url == null) value.url = '#';
                    rec.push('<div style="padding:1rem 0;display: flex;' +
                            '         align-items: center;' +
                            '         width: 100%;">' +
                            '     <a href="' + value.url + '"> <img src="' + value.image + '" alt="no image" class="userImage" style="width:auto!important;left:50%;    transform: translate(-50%, 0%);"> </a>' +
                            '    </div>  ' +
                            '    <input class="user_id" value="0" id="user_id" hidden="">  ');
                });

                if (len < 7) {
                    $('#stack_iman li').last().after(before + rec[0] + after);
                    return false;
                }
                var k = 0;
                $.each($('#stack_iman li'), function (index1, value2) {
                    if (i % 7 === 0) {
                        if ($(rec).length > 1) {
                            $(value2).after(before + rec[k] + after);
                        }
                        k++;
                    }
                    i++;
                });
                if (data.count == k || data.count > k) {
                    $('#stack_iman li').last().after(before + rec[k] + after);
                }
            }
        }
    });
});

setTimeout(function () {
    (function (window) {
        'use strict';
        $('#stack_iman li').last().addClass('last');
        var support = {animations: Modernizr.cssanimations},
                animEndEventNames = {'WebkitAnimation': 'webkitAnimationEnd', 'OAnimation': 'oAnimationEnd', 'msAnimation': 'MSAnimationEnd', 'animation': 'animationend'},
                animEndEventName = animEndEventNames[ Modernizr.prefixed('animation') ],
                onEndAnimation = function (el, callback) {
                    var onEndCallbackFn = function (ev) {
                        if (support.animations) {
                            if (ev.target != this) return;
                            this.removeEventListener(animEndEventName, onEndCallbackFn);
                        }
                        if (callback && typeof callback === 'function') callback.call();
                    };
                    if (support.animations) {
                        el.addEventListener(animEndEventName, onEndCallbackFn);
                    } else {
                        onEndCallbackFn();
                    }
                };
        function extend(a, b) {
            for (var key in b) {
                if (b.hasOwnProperty(key)) a[key] = b[key];
            }
            return a;
        }

        function Stack(el, options) {
            console.log(options)
            this.el = el;
            this.options = extend({}, this.options);
            extend(this.options, options);
            this.items = [].slice.call(this.el.children);
            this.itemsTotal = this.items.length;
            if (this.options.infinite && this.options.visible >= this.itemsTotal || !this.options.infinite && this.options.visible > this.itemsTotal || this.options.visible <= 0) {
                this.options.visible = 1;
            }
            this.current = 0;
            this._init();
        }

        Stack.prototype.options = {
            // stack's perspective value
            perspective: 1000,
            // stack's perspective origin
            perspectiveOrigin: '50% -50%',
            // number of visible items in the stack
            visible: 3,
            // infinite navigation
            infinite: true,
            // callback: when reaching the end of the stack
            onEndStack: function () {
                return false;
            },
            // animation settings for the items' movements in the stack when the items rearrange
            // object that is passed to the dynamicsjs animate function (see more at http://dynamicsjs.com/)
            // example:
            // {type: dynamics.spring,duration: 1641,frequency: 557,friction: 459,anticipationSize: 206,anticipationStrength: 392}
            stackItemsAnimation: {
                duration: 500,
                type: dynamics.bezier,
                points: [{'x': 0, 'y': 0, 'cp': [{'x': 0.25, 'y': 0.1}]}, {'x': 1, 'y': 1, 'cp': [{'x': 0.25, 'y': 1}]}]
            },
            // delay for the items' rearrangement / delay before stackItemsAnimation is applied
            stackItemsAnimationDelay: 0,
            // animation settings for the items' movements in the stack before the rearrangement
            // we can set up different settings depending on whether we are approving or rejecting an item
        };
        
        // set the initial styles for the visible items
        Stack.prototype._init = function () {
            // set default styles
            // first, the stack
            this.el.style.WebkitPerspective = this.el.style.perspective = this.options.perspective + 'px';
            this.el.style.WebkitPerspectiveOrigin = this.el.style.perspectiveOrigin = this.options.perspectiveOrigin;
            var self = this;
            // the items
            for (var i = 0; i < this.itemsTotal; ++i) {
                var item = this.items[i];
                if (i < this.options.visible) {
                    item.style.opacity = 1;
                    item.style.pointerEvents = 'auto';
                    item.style.zIndex = i === 0 ? parseInt(this.options.visible + 1) : parseInt(this.options.visible - i);
                    item.style.WebkitTransform = item.style.transform = 'translate3d(0px, 0px, ' + parseInt(-1 * 50 * i) + 'px)';
                } else {
                    item.style.WebkitTransform = item.style.transform = 'translate3d(0,0,-' + parseInt(this.options.visible * 50) + 'px)';
                }
            }
            classie.add(this.items[this.current], 'stack__item--current');
        };
        Stack.prototype.reject = function (callback) {
            this._next('reject', callback);
        };
        Stack.prototype.accept = function (callback) {
            this._next('accept', callback);
        };
        Stack.prototype.restart = function () {
            this.hasEnded = false;
            this._init();
        };
        Stack.prototype._next = function (action, callback) {
            if (this.isAnimating || (!this.options.infinite && this.hasEnded))
                return;
            this.isAnimating = true;
            var currentItem = this.items[this.current];
            classie.remove(currentItem, 'stack__item--current');
            var nextLi = $(currentItem).next('li').find('.user_id').val();
            var Lastli = $(currentItem).hasClass('last');
            if (Lastli == true) location.reload(true);
            if (nextLi == 0) {
                $('.hideForAd').addClass('d-none');
                $('.stack').css('height', '200px');
            } else {
                $('.hideForAd').removeClass('d-none');
                $('.stack').css('height', '300px');
            }
            var userId = $(currentItem).find(".user_id").val();
            var types = [];
            $(currentItem).find(".relation").each(function () {
                types.push($(this).val());
            });            
            if ($(currentItem).find(".user_id").val() != 0) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/userReview",
                    data: {data: action, to_user_id: userId, relation: types},
                    dataType: 'json',
                    context: this,
                    success: function (data) {
                        if (data.status == 'success') {
                            if (data.count > 0) {
                                $('.connectionCount').removeClass('d-none');
                                $('.myConnectionCount').html(data.count);
                            }
                            if (data.isConnected == true) {
                                $('#fromUserConnectedImg').attr('src', data.fromUserPicture);
                                $('#toUserConnectedImg').attr('src', data.toUserPicture);
                                $('#connectedWithName').html(data.toUserName);                            
                                $('#toUserConnectedProfile').attr('href', '/user-profile/' + data.toUserToken);
                                $('#connectedModal').modal('show');
                            }
                        }
                    }
                });
            }
            
            // add animation class
            classie.add(currentItem, action === 'accept' ? 'stack__item--accept' : 'stack__item--reject');
            var self = this;
            onEndAnimation(currentItem, function () {
                // reset current item
                currentItem.style.opacity = 0;
                currentItem.style.pointerEvents = 'none';
                currentItem.style.zIndex = -1;
                currentItem.style.WebkitTransform = currentItem.style.transform = 'translate3d(0px, 0px, -' + parseInt(self.options.visible * 50) + 'px)';
                classie.remove(currentItem, action === 'accept' ? 'stack__item--accept' : 'stack__item--reject');
                self.items[self.current].style.zIndex = self.options.visible + 1;
                self.isAnimating = false;
                if (callback) callback();
                if (!self.options.infinite && self.current === 0) {}
            });
            // set style for the other items
            for (var i = 0; i < this.itemsTotal; ++i) {
                if (i >= this.options.visible)
                    break;
                if (!this.options.infinite) {
                    if (this.current + i >= this.itemsTotal - 1)
                        break;
                    var pos = this.current + i + 1;
                } else {
                    var pos = this.current + i < this.itemsTotal - 1 ? this.current + i + 1 : i - (this.itemsTotal - this.current - 1);
                }

                var item = this.items[pos],
                        // stack items animation
                        animateStackItems = function (item, i) {
                            item.style.pointerEvents = 'auto';
                            item.style.opacity = 1;
                            item.style.zIndex = parseInt(self.options.visible - i);
                            dynamics.animate(item, {
                                translateZ: parseInt(-1 * 50 * i)
                            }, self.options.stackItemsAnimation);
                        };
                setTimeout(function (item, i) {
                    return function () {
                        var preAnimation;
                        if (self.options.stackItemsPreAnimation) preAnimation = action === 'accept' ? self.options.stackItemsPreAnimation.accept : self.options.stackItemsPreAnimation.reject;

                        if (preAnimation) {
                        
                            // items "pre animation" properties
                            var animProps = {};
                            for (var key in preAnimation.animationProperties) {
                                var interval = preAnimation.elastic ? preAnimation.animationProperties[key] / self.options.visible : 0;
                                animProps[key] = preAnimation.animationProperties[key] - Number(i * interval);
                            }

                            // this one remains the same..
                            animProps.translateZ = parseInt(-1 * 50 * (i + 1));
                            preAnimation.animationSettings.complete = function () {
                                animateStackItems(item, i);
                            };

                            for (var key in preAnimation.animationProperties) {
                                var interval = preAnimation.elastic ? preAnimation.animationProperties[key] / self.options.visible : 0;
                                animProps[key] = preAnimation.animationProperties[key] - Number(i * interval);
                            }

                            // this one remains the same..
                            animProps.translateZ = parseInt(-1 * 50 * (i + 1));
                            preAnimation.animationSettings.complete = function () {
                                animateStackItems(item, i);
                            };

                            dynamics.animate(item, animProps, preAnimation.animationSettings);
                        } else {
                            animateStackItems(item, i);
                        }
                    };
                }(item, i), this.options.stackItemsAnimationDelay);
            }

            // update current
            this.current = this.current < this.itemsTotal - 1 ? this.current + 1 : 0;
            classie.add(this.items[this.current], 'stack__item--current');
        }
        window.Stack = Stack;

    })(window);
}, 1000)
