import ClientController from './ClientController'
import CategoryController from './CategoryController'
import Settings from './Settings'

const Controllers = {
    ClientController: Object.assign(ClientController, ClientController),
    CategoryController: Object.assign(CategoryController, CategoryController),
    Settings: Object.assign(Settings, Settings),
}

export default Controllers