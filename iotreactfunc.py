@listener(channel="arklive")
def arkmap(c, p, m, redis):
    redis.publish("aii.arklive", m)
    input = json.loads(m)
    players = []
    tribes = []
    out = dict(
        map=input.get("map"),
        serverclock=input.get("serverclock"),
        marker=players,
        tribe_markers=tribes,
    )

    pla = input["players"]

    for pid, p in (pla.items() if pla else ()):
        color = "darkblue"
        if pid == yeensteam:
            color = "black"
        elif pid == purpsteam:
            color = "purple"
        players.append([
        p.get("x", 0),
        p.get("y", 0),
        "user-o",
        color,
        p.get("tribename", ""),
        p.get("x_ue4", 0),
        p.get("y_ue4", 0),
        p.get("z_ue4", 0),
        ])

    tri = input["tribes"]

    for tid, t in (tri.items() if tri else ()):
        tribes.append([
            t.get("x", 0),
            t.get("y", 0),
            "home",
            "green",
            t.get("tribename", ""),
            t.get("tribename", ""),
            t.get("x_ue4", 0),
            t.get("y_ue4", 0),
            t.get("z_ue4", 0),
            0,
       ])
    j = json.dumps(out)
    redis.set("arklivemap", j)
    redis.publish("arklivemap", j)