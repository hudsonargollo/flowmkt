import ReactDOM from "react-dom/client";
import "reactflow/dist/style.css";
import { useCallback, useMemo, useState } from "react";
import { v4 as uuidv4 } from "uuid";
import ReactFlow, {
    MiniMap,
    Controls,
    Background,
    useNodesState,
    useEdgesState,
    addEdge,
    Position,
} from "reactflow";

import SendTextMessageNode from "./nodes/SendTextMessageNode";
import SendImageNode from "./nodes/SendImageNode";
import SendVideoNode from "./nodes/SendVideoNode";
import SendDocumentNode from "./nodes/SendDocumentNode";
import SendAudioNode from "./nodes/SendAudioNode";
import SendLocationNode from "./nodes/SendLocationNode";
import SendListMessageNode from "./nodes/SendListMessageNode";
import Sidebar from "./nodes/Sidebar";
import TriggerNode from "./nodes/TriggerNode";
import SendCtaUrl from "./nodes/SendCtaUrl";
import SendButtonNode from "./nodes/SendButtonNode";
import axios from "axios";

// Portuguese translation dictionary
const translations = {
    // Node types
    "Text Message": "Mensagem de Texto",
    "Send Image": "Enviar Imagem",
    "Video Message": "Mensagem de Vídeo",
    "Send Video": "Enviar Vídeo",
    "Document Message": "Mensagem de Documento",
    "Send Document": "Enviar Documento",
    "Audio Message": "Mensagem de Áudio",
    "Send Audio": "Enviar Áudio",
    "List Message": "Mensagem de Lista",
    "Interactive List": "Lista Interativa",
    "URL Message": "Mensagem de URL",
    "Location Message": "Mensagem de Localização",
    "Send Location": "Enviar Localização",
    "Button Message": "Mensagem de Botão",
    "Send Template": "Enviar Template",
    
    // Node descriptions
    "Send a simple text message to the user.": "Enviar uma mensagem de texto simples para o usuário.",
    "Send an image message to the user.": "Enviar uma mensagem de imagem para o usuário.",
    "Send a video file as a message.": "Enviar um arquivo de vídeo como mensagem.",
    "Send a document or file to the user.": "Enviar um documento ou arquivo para o usuário.",
    "Send an audio clip or voice message.": "Enviar um clipe de áudio ou mensagem de voz.",
    "Send a structured list message with options.": "Enviar uma mensagem de lista estruturada com opções.",
    "Send a call-to-action message containing a URL.": "Enviar uma mensagem de chamada para ação contendo uma URL.",
    "Share a location pin with the user.": "Compartilhar um pin de localização com o usuário.",
    "Make conditional choices with a interactive buttons.": "Fazer escolhas condicionais com botões interativos.",
    
    // Actions and buttons
    "Add Node": "Adicionar Nó",
    "Save Flow": "Salvar Fluxo",
    "Update Flow": "Atualizar Fluxo",
    "Cancel": "Cancelar",
    "Save": "Salvar",
    "Add Button": "Adicionar Botão",
    "Add node as a step": "Adicionar nó como uma etapa",
    "Drag and drop to add node": "Arraste e solte para adicionar nó",
    
    // Placeholders
    "Type your message here...": "Digite sua mensagem aqui...",
    "Enter message body...": "Digite o corpo da mensagem...",
    "Enter footer text...": "Digite o texto do rodapé...",
    "Flow Name": "Nome do Fluxo",
    "Enter Flow Name": "Digite o Nome do Fluxo",
    "Latitude": "Latitude",
    "Longitude": "Longitude",
    "Value for": "Valor para",
    
    // Status messages
    "Uploading...": "Enviando...",
    "No Image Selected": "Nenhuma Imagem Selecionada",
    "No video selected": "Nenhum vídeo selecionado",
    "No audio selected": "Nenhum áudio selecionado",
    "No document selected": "Nenhum documento selecionado",
    "No data found": "Nenhum dado encontrado",
    
    // Labels
    "Buttons (max 3)": "Botões (máx 3)",
    "Button": "Botão",
    "Preview": "Visualizar",
    "Header Variables": "Variáveis do Cabeçalho",
    "Body Variables": "Variáveis do Corpo",
    
    // Error messages
    "Please enter a flow name.": "Por favor, digite um nome para o fluxo.",
    "The button label cannot exceed 20 characters.": "O rótulo do botão não pode exceder 20 caracteres.",
    "The button body cannot exceed 1024 characters.": "O corpo do botão não pode exceder 1024 caracteres.",
    "The footer text cannot exceed 60 characters.": "O texto do rodapé não pode exceder 60 caracteres.",
};

// Translation helper function
export const t = (key) => {
    return translations[key] || key;
};

const INNER_HEIGHT = window.innerHeight / 2 - 340;

var triggerType = "new_message";
var ExKeyword = "";

try {
    triggerType = document.getElementById("flow-builder").dataset.trigger;
    ExKeyword = document.getElementById("flow-builder").dataset.keyword;
} catch (e) {}

const initialNodes = [
    {
        id: "1",
        type: "triggerNode",
        position: { x: -700, y: INNER_HEIGHT },
        data: {
            nodeId: "1",
            trigger: triggerType,
            keyword: ExKeyword,
            handles: [{ type: "source", position: Position.Right }],
        },
    },
];

function FlowBuilder() {
    const flowBuilderElement = document.getElementById("flow-builder");
    let existingNodes = [];
    let existingEdges = [];
    let existingName = "";
    let editing = false;
    let existingFlowId = null;

    try {
        existingNodes = JSON.parse(flowBuilderElement.dataset.nodes || "[]");
        existingEdges = JSON.parse(flowBuilderElement.dataset.edges || "[]");
        existingName = flowBuilderElement.dataset.name || "";
        existingFlowId = flowBuilderElement.dataset.id || null;
        if (existingNodes.length) editing = true;
    } catch (e) {
        console.error("Failed to parse existing flow data:", e);
    }

    const [isEditing] = useState(editing);
    const [flowId] = useState(existingFlowId);

    if (existingNodes.length && existingEdges.length) {
        initialNodes.push(...existingNodes);
    }

    const [nodes, setNodes, onNodesChange] = useNodesState(initialNodes);
    const [edges, setEdges, onEdgesChange] = useEdgesState(existingEdges);
    const [isSidebarOpen, setIsSidebarOpen] = useState(false);
    const [showModal, setShowModal] = useState(false);
    const [flowName, setFlowName] = useState(existingName);

    const nodeTypes = useMemo(
        () => ({
            triggerNode: (props) => (
                <TriggerNode {...props} setNodes={setNodes} />
            ),
            textMessage: (props) => (
                <SendTextMessageNode {...props} setNodes={setNodes} />
            ),
            sendImage: (props) => (
                <SendImageNode {...props} setNodes={setNodes} />
            ),
            sendVideo: (props) => (
                <SendVideoNode {...props} setNodes={setNodes} />
            ),
            sendDocument: (props) => (
                <SendDocumentNode {...props} setNodes={setNodes} />
            ),
            sendAudio: (props) => (
                <SendAudioNode {...props} setNodes={setNodes} />
            ),
            sendLocation: (props) => (
                <SendLocationNode {...props} setNodes={setNodes} />
            ),
            sendCtaUrl: (props) => (
                <SendCtaUrl {...props} setNodes={setNodes} />
            ),
            sendList: (props) => (
                <SendListMessageNode {...props} setNodes={setNodes} />
            ),
            sendButton: (props) => (
                <SendButtonNode {...props} setNodes={setNodes} />
            ),
        }),
        [setNodes]
    );

    const onDragOver = useCallback((event) => {
        event.preventDefault();
        event.dataTransfer.dropEffect = "move";
    }, []);

    const onDrop = useCallback(
        (event) => {
            event.preventDefault();
            const type = event.dataTransfer.getData("application/reactflow");
            if (!type) return;

            const reactFlowBounds = event.currentTarget.getBoundingClientRect();
            const position = {
                x: event.clientX + window.scrollX - reactFlowBounds.right,
                y: event.clientY + window.scrollY - reactFlowBounds.top,
            };
            const id = uuidv4();
            const newNode = {
                id,
                type,
                position,
                data: {
                    message: "",
                    handles: [
                        { type: "target", position: Position.Left },
                        { type: "source", position: Position.Right },
                    ],
                },
            };
            setNodes((nds) => nds.concat(newNode));
        },
        [setNodes]
    );

    const onConnect = useCallback(
        (params) =>
            setEdges((eds) => addEdge({ ...params, animated: true }, eds)),
        [setEdges]
    );

    const BASE_URL = document
        .querySelector("meta[name=APP-DOMAIN]")
        .getAttribute("content");

    const handleSaveFlow = () => {
        setShowModal(true);
    };

    const handleModalSubmit = () => {
        if (!flowName.trim())
            return notify("error", t("Please enter a flow name."));
        const data = {
            nodes,
            edges,
        };

        let URL = `${BASE_URL}/user/flow-builder/store`;
        if (isEditing && flowId)
            URL = `${BASE_URL}/user/flow-builder/update/${flowId}`;
        axios
            .post(URL, {
                data: JSON.stringify(data),
                name: flowName,
            })
            .then((response) => {
                if (response.data.status == "error")
                    return notify("error", response.data.message);

                notify("success", response.data.message);
                setShowModal(false);
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            })
            .catch((error) => {
                notify("error", error.message);
            });

        setNodes(initialNodes);
        setEdges([]);
    };

    return (
        <div style={{ display: "flex", height: "85vh", width: "100%" }}>
            <div style={{ flexGrow: 1, position: "relative" }}>
                <ReactFlow
                    nodes={nodes}
                    edges={edges}
                    onNodesChange={onNodesChange}
                    onEdgesChange={onEdgesChange}
                    onConnect={onConnect}
                    nodeTypes={nodeTypes}
                    onDragOver={onDragOver}
                    onDrop={onDrop}
                    fitView
                >
                    <MiniMap />
                    <Controls />
                    <Background />
                </ReactFlow>

                <div
                    className={`flow_top_button_wrapper ${
                        isSidebarOpen ? "sidebar_open" : ""
                    }`}
                >
                    <button
                        onClick={handleSaveFlow}
                        className="top_btn"
                        data-bs-toggle="tooltip"
                        data-bs-placement="left"
                        data-bs-title={isEditing ? t("Update Flow") : t("Save Flow")}
                    >
                        <i className="las la-save"></i>
                    </button>

                    <button
                        onClick={() => setIsSidebarOpen(true)}
                        className="top_btn"
                        data-bs-toggle="tooltip"
                        data-bs-placement="left"
                        data-bs-title={t("Add node as a step")}
                    >
                        <i className="las la-plus"></i>
                    </button>
                </div>
            </div>
            <Sidebar
                isOpen={isSidebarOpen}
                onClose={() => setIsSidebarOpen(false)}
            />
            <div className={`flow_modal ${showModal ? "show" : ""}`}>
                <div>
                    <h5>{t("Enter Flow Name")}</h5>
                    <div className="form-group">
                        <input
                            type="text"
                            value={flowName}
                            onChange={(e) => setFlowName(e.target.value)}
                            placeholder={t("Flow Name")}
                            autoFocus
                            className="form-control form--control"
                        />
                    </div>
                    <div className="d-flex gap-2 justify-content-end">
                        <button
                            onClick={() => setShowModal(false)}
                            className="btn btn--dark"
                        >
                            <i className="las la-times me-2"></i>
                            {t("Cancel")}
                        </button>
                        <button
                            onClick={handleModalSubmit}
                            className="btn btn--base"
                        >
                            <i className="lab la-telegram me-2"></i>
                            {t("Save")}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}

if (document.getElementById("flow-builder")) {
    ReactDOM.createRoot(document.getElementById("flow-builder")).render(
        <FlowBuilder />
    );
}
