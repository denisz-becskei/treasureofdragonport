let images = [];
function preload() {
    for (let i = 0; i < arguments.length; i++) {
        images[i] = new Image();
        images[i].src = preload.arguments[i];
    }
}

preload(
    "https://i.imgur.com/zXlhJl6.png",
    "https://i.imgur.com/2TAkWbp.png",
    "https://i.imgur.com/AaawF8b.png",
    "https://i.imgur.com/4FR5Iae.png",
    "https://i.imgur.com/g4B0GIf.png",
    "https://i.imgur.com/NyG2GH8.png",
    "https://i.imgur.com/hXMEf0i.png",
    "https://i.imgur.com/krKI6Dl.png",
    "https://i.imgur.com/TpbEsaZ.png",
    "https://i.imgur.com/iKmXPNH.png",
    "https://i.imgur.com/YpnlfDa.png",
    "https://i.imgur.com/TCF680g.png",
    "https://i.imgur.com/NhGXUFg.png",
    "https://i.imgur.com/MvWObyQ.png",
    "https://i.imgur.com/Xiw8RKk.png",
    "https://i.imgur.com/46S2XOx.png",
    "https://i.imgur.com/eMZAhqR.png",
    "https://i.imgur.com/zgGGRzk.png",
    "https://i.imgur.com/sy4nGJ3.png",
    "https://i.imgur.com/f6F3hTs.png",
    "https://i.imgur.com/rgP3hd8.png",
    "https://i.imgur.com/d1dWVnb.png",
    "https://i.imgur.com/hD3SRE4.png",
    "https://i.imgur.com/l9M3kan.png",
    "https://i.imgur.com/6hVU8Dh.png",
    "https://i.imgur.com/Ea1NmkK.png",
    "https://i.imgur.com/ejPTOc9.png",
    "https://i.imgur.com/x9APW4y.png",
    "https://i.imgur.com/GK3o61U.png",
    "https://i.imgur.com/izxlbLP.png",
    "https://i.imgur.com/3L30iNI.png",
    "https://i.imgur.com/aC8NZWv.png",
    "https://i.imgur.com/RaH2pvt.png",
    "https://i.imgur.com/9nqqix3.png",
    "https://i.imgur.com/gjOVtNj.png",
    "https://i.imgur.com/nIDiqYV.png",
    "https://i.imgur.com/NTASjG2.png",
    "https://i.imgur.com/nIyDcDt.png",
    "https://i.imgur.com/aK0Vuqk.png",
    "https://i.imgur.com/3Z8OGNA.png",
    "https://i.imgur.com/hJMSdFx.png",
    "https://i.imgur.com/55o2gDB.png",
    "https://i.imgur.com/oIzayNY.png",
    "https://i.imgur.com/xwR7B1e.png",
    "https://i.imgur.com/kdJTjCe.png",
    "https://i.imgur.com/GkNWB8i.png",
    "https://i.imgur.com/2OALEpQ.png"
)

preload();