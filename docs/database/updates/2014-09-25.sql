CREATE TABLE sphinx_delta
(
    lang_id INTEGER PRIMARY KEY NOT NULL,
    index_start_date datetime DEFAULT NULL
);
CREATE INDEX modified_idx ON sentences (modified);
