CREATE TABLE IF NOT EXISTS utilisateurs(
    uuid TEXT NOT NULL,
    username TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    profile_picture TEXT NOT NULL,
    biography TEXT NOT NULL,
    is_admin INT NOT NULL,
    date_creation TIMESTAMP NOT NULL,
    is_premium INT NOT NULL,
    project_participating TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS projets (
    uuid TEXT NOT NULL,
    owner TEXT NOT NULL,
    nbr_upvote BIGINT NOT NULL,
    nbr_downvote BIGINT NOT NULL,
    participants TEXT NOT NULL,
    creation_date TIMESTAMP NOT NULL,
    is_featured INT NOT NULL,
    title TEXT NOT NULL,
    tags TEXT NOT NULL,
    status INT NOT NULL,
    limit_date TIMESTAMP NOT NULL,
    pictures TEXT NOT NULL,
    resume TEXT NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS commentaires (
    uuid TEXT NOT NULL,
    project TEXT NOT NULL,
    commentaire TEXT NOT NULL,
    user TEXT NOT NULL,
    date_send TIMESTAMP NOT NULL
);

CREATE TABLE IF NOT EXISTS messages (
    user_from TEXT NOT NULL,
    user_to TEXT NOT NULL,
    date_send TIMESTAMP NOT NULL,
    text_message TEXT NOT NULL
)
