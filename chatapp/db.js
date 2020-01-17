const Sequelize = require('sequelize');
const sequelize = new Sequelize(
    'broadcastdb', // database name
    'root', // username
    '', // password
    {
        'host': '127.0.0.1', // database host
        'dialect': 'mysql',  // the type of database to use
        'operatorsAliases': false
    }
);

const Broadcast = sequelize.define('broadcast',
    {
        id: {
            type: Sequelize.INTEGER,
            primaryKey: true,
            autoIncrement: true
        },
        user_id: {
            type: Sequelize.INTEGER,
        },
        title: {
            type: Sequelize.STRING,
            allowNull: true
        },
        pic: {
            type: Sequelize.STRING,
            allowNull: true
        },
        is_start: {
            type: Sequelize.INTEGER,
            allowNull: true
        },
        start_time: {
            type: Sequelize.DATE,
            allowNull: true
        },
        type: {
            type: Sequelize.STRING,
            allowNull: true
        },
        category_id: {
            type: Sequelize.INTEGER,
            allowNull: true
        },
        user_num: {
            type: Sequelize.INTEGER
        },
        bid: {
            type: Sequelize.STRING
        },
        active: {
            type: Sequelize.INTEGER
        }
    }, {
        createdAt: 'created_at',
        updatedAt: 'updated_at'
    });

const User = sequelize.define('user',
    {
        id: {
            type: Sequelize.INTEGER,
            primaryKey: true,
            autoIncrement: true
        },
        view_num: {
            type: Sequelize.INTEGER
        },
        status: {
            type: Sequelize.INTEGER
        },
        active: {
            type: Sequelize.INTEGER
        }
    }, {
        createdAt: 'created_at',
        updatedAt: 'updated_at'
    });

exports.Broadcast = Broadcast;
exports.User = User;